<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use Core\Validate;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\CommentModel;



class CommentController{
    public Validate $validator;
    public UserModel $userModel;
    public PostModel $postModel;
    public CategoryModel $categoryModel;
    public CommentModel $commentModel;


    public function __construct(){
        $this->validator= new Validate;
        $this->userModel = new UserModel;
        $this->postModel = new PostModel;
        $this->categoryModel = new CategoryModel;
        $this->commentModel = new CommentModel;
    }

    public function create($body){

        $body['user_id'] = isLoggedIn()->id;
        $singlePost=[];
        $post = $this->postModel->getSingle($body['id']);

        $singlePost['id'] = $post ->id;
        $singlePost['title'] = $post ->title;
        $singlePost['description'] = $post->description;
        $singlePost['image_path'] = $post->image_path;
        $singlePost['category'] =  $this->categoryModel->getSingle($post->category_id)->name;
        $singlePost['category_id'] = $post->category_id;
        $singlePost['created_at'] = $post->created_at;
        $singlePost['user'] = $this->userModel->getSingle($post->user_id)->firstname;


        $readNextPost = [];
        $post = $this->postModel->getWithCondition(['popular' =>1],1);
        $post = $post[0];

        $readNextPost['title'] = $post->title;
        $readNextPost['description'] = $post->description;
        $readNextPost['image_path'] = $post->image_path;
        $readNextPost['category'] =$this->categoryModel->getSingle($post->category_id)->name;
        $readNextPost['category_id'] = $post->category_id;
        $readNextPost['created_at'] = $post->created_at;
        $readNextPost['user'] =  $this->userModel->getSingle($post->user_id)->firstname;
        $readNextPost['id'] = $post->id;

        
        $comments=[];

        foreach( $this->commentModel->getWithCondition( ['post_id' =>$singlePost['id']])  ??[] as $key => $comment) {
            $comments[$comment->id]['id'] = $comment->id;
            $comments[$comment->id]['content'] = $comment->content;
            $comments[$comment->id]['user_id'] = $comment->user_id;
            $comments[$comment->id]['parent_id'] = $comment->parent_id;
            $comments[$comment->id]['user_name'] = $this->userModel->getSingle($comment->user_id)->firstname;
        }


        if($this->validator->validate($this->commentModel->commentRules(),$body)){
            if($this->commentModel->createComment($body)){
                redirect('/article?id='.$body['id']);
            }
        }

        return render('article',[
            'singlePost'=>$singlePost,
            'comments' => $comments,
            'validate' => $this->validator
        ]);

    }


    public function comments($body){
        setLayout('adminLayout');

        $currentPage =1;
        $offset=0;
        $limit = 10;

        if(isset($body['page']) && $body['page']!=1){
            $currentPage = $body['page'];
            $offset = (($currentPage-1)*$limit);
        }

        $like = null;
        if (isset($body['q']) && $body['q'] != '') {
            $like = $body['q'];
        }   

        $allComments =[];
        $countAllComments =0;
        if(isLoggedIn()->role==2){
            $posts = $this->postModel->getWithCondition(['user_id' => isLoggedIn()->id]);

            foreach($posts as $key => $post){
                $allComments = array_merge($allComments , $this->commentModel->getWithCondition(['post_id' => $post->id, 'status'=>1],$limit,$offset,$like));
                $countAllComments += count($this->commentModel->getWithCondition(['post_id' => $post->id, 'status'=>1]));
            }


        }else{
            $allComments = $this->commentModel->getWithCondition(null,$limit,$offset,$like);
            $countAllComments = count($this->commentModel->getWithCondition(null,null,null,$like));
        }

        $data=[];
        foreach($allComments as $key => $comment){
            $data[$comment->id]['username']= $this->userModel->getSingle($comment->user_id)->firstname;
            $data[$comment->id]['postname']= $this->postModel->getSingle($comment->post_id)->title;
        }


        $numberOfPages = floor($countAllComments / $limit);
        if($countAllComments % $limit !=0){
            $numberOfPages++;
        }


        $pagination['numberOfPages'] = $numberOfPages;
        $pagination['currentPage'] = $currentPage;

        return render('admin/comments/comments', [
            'comments'=>$allComments,
            'pagination'=>$pagination,    
            'q'=>$like,  
            'data' => $data,
        ]);
    }

    public function edit($body){

        if(isLoggedIn()->role==2 && $this->commentModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            setFlash('error', 'you can not acess this page');
            redirect('/admin/comments');
        }

        setLayout('adminLayout');

        $comment = $this->commentModel->getSingle($body['id']);
        return render('admin/comments/form', ['comment' => $comment]);
    }
   

    public function update($body){

        if(isLoggedIn()->role==2 && $this->commentModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            redirect('/admin/comments');
            setFlash('restricted_access', "You can not access this comment");
        }

        setLayout('adminLayout');
        $id = $body['id'];

        if($this->validator->validate($this->commentModel->commentRules(),$body)){
            if($this->commentModel->updateComment($id, $body)){
                setFlash('success',"Comment Updated");
                redirect('/admin/comments');
            }
        }

        return render('admin/comments/form');
    }

    public function delete($body)
    {   

        if(isLoggedIn()->role==2 && $this->commentModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            setFlash('error', 'you can not acess this page');
            redirect('/admin/comments');
        }

        if($this->commentModel->delete(['id'=>$body['id']])){
            setFlash('success',"Comment Deleted");
            redirect("/admin/comments");
        }

        setFlash('error',"something went wrong, the comment isn't deleted");
        redirect("/admin/comments");
    
    }

}
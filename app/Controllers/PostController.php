<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use Core\Validate;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\CommentModel;



class PostController{
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

    public function article($body){

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
            $comments[$comment->id]['status'] = $comment->status;
            $comments[$comment->id]['user_name'] = $this->userModel->getSingle($comment->user_id)->firstname;
        }

        return render('article',[
            'singlePost'=>$singlePost,
            'readNextPost'=> $readNextPost,
            'comments' => $comments,
        ]);

    }

    public function posts($body){

        setLayout('adminLayout');

        $params = null;
        if(isLoggedIn()->role == 2){
            $params['user_id'] = isLoggedIn()->id;
        }

        $currentPage =1;
        $offset=0;
        $limit = 5;

        if(isset($body['page']) && $body['page']!=1){
            $currentPage = $body['page'];
            $offset = (($currentPage-1)*$limit);
        }

        
        $like = null;
        if (isset($body['q']) && $body['q'] != '') {
            $like = $body['q'];
        }
        
        $allPosts = $this->postModel->getWithCondition($params,$limit,$offset,$like);
        $countAllPosts = count($this->postModel->getWithCondition($params,null,null,$like));


        setSession('like',$like);
        $numberOfPages = floor($countAllPosts / $limit);
        
        if($countAllPosts % $limit !=0){
            $numberOfPages++;
        }


        $pagination['numberOfPages'] = $numberOfPages;
        $pagination['currentPage'] = $currentPage;


        $categories=[];
        foreach($this->categoryModel->getAll()??[] as $key => $category) {
            $categories[$category->id]['name'] = $category->name;
        }
        return render('admin/posts/posts', [
            'posts'=>$allPosts,
            'categories' => $categories,
            'pagination' => $pagination,
            'q'=>$like,    
        ]);

    }


    public function edit($body)
    { 

        if(isLoggedIn()->role==2 && $this->postModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            setFlash('error', 'you can not acess this page');
            redirect('/admin/posts');
        }

        setLayout('adminLayout');
        $post = $this->postModel->getWithCondition(['id'=>$body['id']]);
        $post = $post[0];
        
        return render('admin/posts/form',['post'=>$post , 'categories' => $this->categoryModel->getAll()]);
    }

    public function update($body)
    {
        if(isLoggedIn()->role==2 && $this->postModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            setFlash('error', 'you can not acess this page');
            redirect('/admin/posts');
        }

        setLayout('adminLayout');

        if(!isset($body['featured'])){
            $body['featured'] =0;
        }

        if(!isset($body['popular'])){
            $body['popular'] =0;
        }

        if($this->validator->validate($this->postModel->getUpdateRules(),$body,$this->userModel)){
            if(isset($body['image_path']['tmp_name'])){   
                $file = $body['image_path'];
                $temp = explode(".", $file["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $target = "upload/".$newfilename;
                if (!move_uploaded_file($file["tmp_name"], $target)) {
                    setFlash('image_upload_error','Problem in uploading image files.');
                    redirect('/admin/post/update?id='.$body['id']);
                }
                $body['image_path'] = $newfilename; 
            }else{
                unset($body['image_path']);
            }

            if($this->postModel->updatePost($body['id'],$body)){
                setFlash('success',"Post Updated");
                redirect("/admin/posts");
            }            
        }

        return render('admin/posts/form', ['validate' => $this->validator]);

    }

    

    public function add()
    {
        setLayout('adminLayout');
        return render('admin/posts/form',['categories' => $this->categoryModel->getAll()]);
    }

    public function create($body)
    {   
        setLayout('adminLayout');

        if($this->validator->validate($this->postModel->newPostRules(),$body,$this->userModel)){
            if(isset($body['image_path']) ){   
                $file = $body['image_path'];
                $temp = explode(".", $file["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $target = "upload/".$newfilename;
                if (!move_uploaded_file($file["tmp_name"], $target)) {
                    setFlash('image_upload_error','Problem in uploading image files.');
                    redirect('/admin/post/add');
                }
                $body['image_path'] = $newfilename; 
            }

            if($this->postModel->addNewPost($body)){
                setFlash('success',"Post Created");
                redirect("/admin/posts");
            }            
        }

        return render('admin/posts/form', ['validate' => $this->validator,'categories' => $this->categoryModel->getAll()]);

    }


    public function delete($body)
    {   

        if(isLoggedIn()->role==2 && $this->postModel->getSingle($body['id'])->user_id != isLoggedIn()->id){
            setFlash('error', 'you can not acess this page');
            redirect('/admin/posts');
        }

        if($this->postModel->delete(['id'=>$body['id']])){
            setFlash('success',"Post Deleted");
            redirect("/admin/posts");
        }

        setFlash('error',"something went wrong, the post isn't deleted");
        redirect("/admin/posts");
    }



    



    
}
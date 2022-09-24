<?php
namespace App\Controllers;

use Core\Validate;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;


class CategoryController{
    public Validate $validator;
    public CategoryModel $categoryModel;
    public UserModel $userModel;
    public PostModel $postModel;


    public function __construct(){
        $this->validator= new Validate;
        $this->categoryModel = new CategoryModel;
        $this->userModel = new UserModel;
        $this->postModel = new PostModel;
    }

    public function category($body){

        $condition = null;
        $selectedId = null;
        $like = null;

        if(isset($body['category_id']) && $body['category_id'] != ''){
            $condition =['category_id' => $body['category_id']] ;
            $selectedId= $body['category_id'];
        }

        if(isset($body['q']) && $body['q'] !=''){
            $like = $body['q'];
        }

        $allPosts = [];
        foreach( $this->postModel->getWithCondition($condition,null,null,$like)??[] as $key => $post) {
            $allPosts[$post->id]['title'] = $post->title;
            $allPosts[$post->id]['description'] = $post->description;
            $allPosts[$post->id]['image_path'] = $post->image_path;
            $allPosts[$post->id]['category'] = $this->categoryModel->getSingle($post->category_id)->name;
            $allPosts[$post->id]['category_id'] = $post->category_id;
            $allPosts[$post->id]['created_at'] = $post->created_at;
            $allPosts[$post->id]['user'] = $this->userModel->getSingle($post->user_id)->firstname;
        }

        return render('category',[
            'allPosts' => $allPosts,
            'selectedId'=>$selectedId, 
            'categories' => $this->categoryModel->getAll(),
        ]);
    }


    public function categories($body){
        setLayout('adminLayout');

        $currentPage =1;
        $offset=0;
        $limit = 5;

        if(isset($body['page']) && $body['page']!=1){
            $currentPage = $body['page'];
            $offset = (($currentPage-1)*$limit);
        }

        $like = '';
        if (isset($body['q']) && $body['q'] != '') {
            $like = $body['q'];
            $allCategories = $this->categoryModel->getWithCondition(null,$limit,$offset,$like);
            $countAllUsers = count($this->categoryModel->getWithCondition(null,null,null,$like));

        }else{

            $allCategories = $this->categoryModel->getWithCondition(null,$limit,$offset);
            $countAllUsers = count($this->categoryModel->getAll());
        }

        setSession('like',$like);
        $numberOfPages = floor($countAllUsers / $limit);
        
        if($countAllUsers % $limit !=0){
            $numberOfPages++;
        }

        $pagination['numberOfPages'] = $numberOfPages;
        $pagination['currentPage'] = $currentPage;

        return render('admin/categories/categories', [
            'categories'=>$allCategories,
            'pagination' => $pagination,
            'q'=>$like,

        ]);

    }

    public function edit($body)
    {   
        setLayout('adminLayout');
        $category = $this->categoryModel->getWithCondition(['id'=>$body['id']]);
        $category = $category[0];

        return render('admin/categories/form',['category'=>$category]);
    }

    public function update($body)
    {    
        setLayout('adminLayout');
        if($this->validator->validate($this->categoryModel->updateCategoryRules(),$body)){
            if($this->categoryModel->updateCategory($body['id'],$body)){
                setFlash('success',"Category Updated");
                redirect("/admin/categories");
            }            
        }
        return render('admin/categories/form', ['validate' => $this->validator]);

    }


    public function add()
    {
        setLayout('adminLayout');
        return render('admin/categories/form');
    }

    public function create($body)
    {
        setLayout('adminLayout');
        if($this->validator->validate($this->categoryModel->newCategoryRules(),$body)){
            if($this->categoryModel->addNewCategory($body)){
                setFlash('success',"Category Created");
                redirect("/admin/categories");
            }            
        }
        return render('admin/categories/form', ['validate' => $this->validator]);
    }

    public function delete($body)
    {    
        if($this->categoryModel->delete(['id'=>$body['id']])){
            setFlash('success',"Category Deleted");
            redirect("http://blog.test/admin/categories");
        }
            
        setFlash('error',"something went wrong, the category isn't deleted");
        redirect("/admin/categories");
    }
    
}
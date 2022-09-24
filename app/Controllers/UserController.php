<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\PostModel;
use Core\Validate;
use App\Models\UserModel;

class UserController{
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

    public function home($body){

        $categories = [];

        foreach($this->categoryModel->getAll()??[] as $key => $category) {
            $categories[$category->id]['name'] = $category->name;
            $categories[$category->id]['totalPosts'] = count($this->postModel->getWithCondition(['category_id' => $category->id]));
        }

        $limit = 5;
        $offset =0;
        $currentPage =1;
        if(isset($body['page']) && $body['page']!=1){
            $currentPage = $body['page'];
            $offset = (($currentPage-1)*$limit);
        }

        $allPosts = [];

        foreach( $this->postModel->getWithCondition(null,$limit,$offset)??[] as $key => $post) {
            $allPosts['all'][$post->id]['title'] = $post->title;
            $allPosts['all'][$post->id]['description'] = $post->description;
            $allPosts['all'][$post->id]['image_path'] = $post->image_path;
            $allPosts['all'][$post->id]['category'] = $categories[$post->category_id]['name'];
            $allPosts['all'][$post->id]['category_id'] = $post->category_id;
            $allPosts['all'][$post->id]['created_at'] = $post->created_at;
            $allPosts['all'][$post->id]['user'] = $this->userModel->getSingle($post->user_id)->firstname;
        }


        foreach( $this->postModel->getWithCondition(['popular' =>1],4,0)??[] as $key => $post) {
            $allPosts['popular'][$post->id]['title'] = $post->title;
            $allPosts['popular'][$post->id]['description'] = $post->description;
            $allPosts['popular'][$post->id]['image_path'] = $post->image_path;
            $allPosts['popular'][$post->id]['category'] = $categories[$post->category_id]['name'];
            $allPosts['popular'][$post->id]['category_id'] = $post->category_id;
            $allPosts['popular'][$post->id]['created_at'] = $post->created_at;
            $allPosts['popular'][$post->id]['user'] = $this->userModel->getSingle($post->user_id)->firstname;
        }

        $featuerdPost = $this->postModel->getWithCondition(['featured' =>1],1);
        $featuerdPost = $featuerdPost[0];
        $allPosts['featuerdPost']['title'] = $featuerdPost->title;
        $allPosts['featuerdPost']['description'] = $featuerdPost->description;
        $allPosts['featuerdPost']['image_path'] = $featuerdPost->image_path;
        $allPosts['featuerdPost']['category'] = $categories[$featuerdPost->category_id]['name'];
        $allPosts['featuerdPost']['category_id'] = $featuerdPost->category_id;
        $allPosts['featuerdPost']['created_at'] = $featuerdPost->created_at;
        $allPosts['featuerdPost']['user'] =  $this->userModel->getSingle($featuerdPost->user_id)->firstname;
        $allPosts['featuerdPost']['id'] = $featuerdPost->id;

        
        $countAllPosts = count($this->postModel->getAll());
        $numberOfPages = floor($countAllPosts / $limit);
        
        if($countAllPosts % $limit !=0){
            $numberOfPages++;
        }

        $pagination['numberOfPages'] = $numberOfPages;
        $pagination['currentPage'] = $currentPage;

        return render('home',
        [
            'allPosts' => $allPosts,
            'categories'=>$categories,
            'pagination'=>$pagination,
        ]);
    }


    public function loginGet(){
        
        return render('login');
    }

    public function loginPost($body){

        if($this->validator->validate($this->userModel->loginRules(),$body,$this->userModel)){
            $user=$this->userModel->login($body);
            if($user){
                setSession('auth_user',$user);
                redirect("/");
            }

            setFlash('login_err',"There was an error with your E-Mail/Password combination. Please try again.");
            redirect("/login");
        }

        return render('login', ['validate'=> $this->validator]);   
    }

    public function logout(){
        unset_session('auth_user');
        redirect("/login");
    }

    public function registerGet(){
        return render('register');
    }

    public function registerPost($body){
        if($this->validator->validate($this->userModel->registerRules(),$body,$this->userModel)){
            if($this->userModel->register($body)){
                setFlash('register_success',"You are registred and now can log in!");
                redirect("/login");
                die('success');
            }            
        }
        return render('register', ['validate' => $this->validator]);
    }

    public function admin(){
        setLayout('adminLayout');

        if(isLoggedIn()->role ==1){
            $data['totalPosts'] = count($this->postModel->getAll());
            $data['totalComments'] = count($this->commentModel->getAll());
            $data['totalUsers'] = count($this->userModel->getAll());
            $data['totalCategories'] = count($this->categoryModel->getAll());
            
        }else{

            $posts = $this->postModel->getWithCondition(['user_id' => isLoggedIn()->id]);
            $data['totalComments'] = 0;

            foreach($posts as $key => $value){
                $data['totalComments'] += count($this->commentModel->getWithCondition(['post_id' => $value->id, 'status'=>1]));
            }
            $data['totalPosts'] = count($posts);
        }
        
        setSession('flag',1);
        return render('admin/dashboard', ['data' => $data]);
    }

    public function users($body){
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
            $allUsers = $this->userModel->getWithCondition(null,$limit,$offset,$like);
            $countAllUsers = count($this->userModel->getWithCondition(null,null,null,$like));

        }else{
            $allUsers = $this->userModel->getWithCondition(null,$limit,$offset);
            $countAllUsers = count($this->userModel->getAll());
        }

        setSession('like',$like);

        $numberOfPages = floor($countAllUsers / $limit);
        if($countAllUsers % $limit !=0){
            $numberOfPages++;
        }

        $pagination['numberOfPages'] = $numberOfPages;
        $pagination['currentPage'] = $currentPage;

        return render('admin/users/users', [
            'users'=>$allUsers,
            'pagination'=>$pagination,    
            'q'=>$like,    
        ]);

    }

    public function add(){
        setLayout('adminLayout');
        return render('admin/users/form');
    }

    public function create($body)
    {   
        setLayout('adminLayout');
        if($this->validator->validate($this->userModel->adminRegisterRules(),$body,$this->userModel)){
            if($this->userModel->register($body)){
                setFlash('success',"User Created");
                redirect("/admin/users");
            }            
        }
        return render('admin/users/form', ['validate' => $this->validator]);
    }

    public function edit($body)
    {   
        setLayout('adminLayout');
        $user = $this->userModel->getWithCondition(['id'=>$body['user_id']]);
        $user = $user[0];

        return render('admin/users/form',['user'=>$user]);
    }

    public function update($body)
    {    
        setLayout('adminLayout');
        
        if(empty($body['password'])){
            unset($body['password']);
        }
       
        if($this->validator->validate($this->userModel->updateRules(),$body,$this->userModel)){
            if($this->userModel->update($body['user_id'],$body)){
                setFlash('success',"User Updated");
                redirect("/admin/users");
            }            
        }

        return render('admin/users/form', ['validate' => $this->validator, 'user_id' => $body['user_id'] ]);

    }

    public function delete($body)
    {   
        if($this->userModel->delete(['id'=>$body['user_id']]) && ($this->postModel->delete(['user_id' => $body['user_id']]) && ($this->commentModel->delete(['user_id' => $body['user_id']] )))){
            setFlash('success',"User Deleted");
            redirect("/admin/users");
        }

        setFlash('error',"something went wrong, the user isn't deleted");
        redirect("/admin/users");
    }


}
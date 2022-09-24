
<?php 
// var_dump($validate);die;

if(getFlash('image_upload_error')): ?>
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card alert alert-danger">
                    <?php echo getFlash('image_upload_error')?>
                </div>
            </div>  
        </div>
    <?php endif; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <h1><?= (isset($post)) ? 'Update Post' : 'Create Post' ?></h1>

            <form action="" method="post" enctype="multipart/form-data">
                
                <input type="hidden" value="<?= isset($post ->user_id) ? $post ->user_id: isLoggedIn()->id ?>"   id="user_id" name="user_id">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" value="<?= isset($post ->title) ? $post ->title: '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('title')) ? 'is-invalid' : '' ?>"  id="title" name="title">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('title')) ? $validate->getFirstError('title') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea  class="form-control  <?php echo (isset($validate) && $validate->hasError('description')) ? 'is-invalid' : '' ?>" id="description" name="description"> <?= isset($post ->description) ? $post ->description: '' ?></textarea>
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('description')) ? $validate->getFirstError('description') : '' ?> 
                    </div>
                </div>

                <div class="mb-3">
                    <input type="file" class=" <?php echo (isset($validate) && $validate->hasError('image_path')) ? 'is-invalid' : '' ?>" id="image_path" name="image_path">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('image_path')) ? $validate->getFirstError('image_path') : '' ?> 
                    </div>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id">
                        <?php foreach($categories as $category): ?>
                            <option value="<?=$category->id ?>" <?php echo (isset($post)) && $category->id==$post->category_id ? "selected" : '' ?>  ><?=$category->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <?php if(isLoggedIn()->role ==1): ?>
                    <div class="mb-3 d-flex " style="gap:20px">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="featured" name="featured"  <?= isset($post ->featured) && $post ->featured==1  ? 'checked' : '' ?>>
                            <label class="form-check-label" for="featured">
                                Featured Post
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="popular" name="popular" <?= isset($post ->popular) && $post ->popular==1  ? 'checked' : '' ?>>
                            <label class="form-check-label" for="popular">
                                Popular Post
                            </label>
                        </div>
                    </div>
                <?php endif;?>
                
                <button type="submit" class="btn btn-primary"><?= (isset($post)) ? 'Update Post' : 'Create Post' ?></button>
            </form>
        </div>
    </div>
</div>

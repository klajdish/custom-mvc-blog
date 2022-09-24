
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <h1><?= (isset($category)) ? 'Update Category' : 'Create Category' ?></h1>

            <form action="" method="post">
            <div class="mb-3">
                    <label for="user_id" class="form-label">Name</label>
                    <input type="text" value="<?= isset($category ->name) ? $category ->name: '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('name')) ? 'is-invalid' : '' ?>"  id="name" name="name">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('name')) ? $validate->getFirstError('name') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea  class="form-control  <?php echo (isset($validate) && $validate->hasError('description')) ? 'is-invalid' : '' ?>" id="description" name="description"> <?= isset($category ->description) ? $category ->description: '' ?></textarea>
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('description')) ? $validate->getFirstError('description') : '' ?> 
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary"><?= (isset($category)) ? 'Update' : 'Create' ?></button>
            </form>
        </div>
    </div>
</div>

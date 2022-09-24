
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
            <h1>Update Comment</h1>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea  class="form-control  <?php echo (isset($validate) && $validate->hasError('content')) ? 'is-invalid' : '' ?>" id="content" name="content"> <?= isset($comment ->content) ? $comment ->content: '' ?></textarea>
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('content')) ? $validate->getFirstError('content') : '' ?> 
                    </div>
                </div>
                
                <?php if(isLoggedIn()->role==1): ?>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="status" id="flexRadioDefault1" <?=$comment->status==1 ? 'checked' : '' ?> >
                        <label class="form-check-label" for="flexRadioDefault1">
                            Approve
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="status" id="flexRadioDefault2" <?=$comment->status==0 ? 'checked' : '' ?> >
                        <label class="form-check-label" for="flexRadioDefault2">
                            Don't approve
                        </label>
                    </div>
                </div>
                <?php endif; ?>





                <button type="submit" class="btn btn-primary">Update Comment</button>
            </form>
        </div>
    </div>
</div>


<div class="container">
    <?php if(getFlash('login_err')): ?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card alert alert-danger">
                        <?php echo getFlash('login_err')?>
                    </div>
                </div>  
            </div>
    <?php endif; ?>

    <?php if(getFlash('register_success')): ?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card alert alert-success">
                        <?php echo getFlash('register_success')?>
                    </div>
                </div>  
            </div>
    <?php endif; ?>

    
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <h1>Log In</h1>
            <form action="/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control <?php echo (isset($validate) && $validate->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('email')) ? $validate->getFirstError('email') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control <?php echo (isset($validate) && $validate->hasError('password')) ? 'is-invalid' : '' ?>" id="exampleInputPassword1" name="password">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('password')) ? $validate->getFirstError('password') : '' ?> 
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

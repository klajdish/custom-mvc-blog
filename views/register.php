
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <h1>Create an account</h1>
            <form action="/register" method="post">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First name</label>
                    <input type="text" class="form-control <?php echo (isset($validate) && $validate->hasError('firstname')) ? 'is-invalid' : '' ?>"  id="firstname" name="firstname">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('firstname')) ? $validate->getFirstError('firstname') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last name</label>
                    <input type="text" class="form-control <?php echo (isset($validate) && $validate->hasError('lastname')) ? 'is-invalid' : '' ?>" id="lastname" name="lastname">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('lastname')) ? $validate->getFirstError('lastname') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?php echo (isset($validate) && $validate->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('email')) ? $validate->getFirstError('email') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?php echo (isset($validate) && $validate->hasError('password')) ? 'is-invalid' : '' ?>" id="password" name="password">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('password')) ? $validate->getFirstError('password') : '' ?> 
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control <?php echo (isset($validate) && $validate->hasError('confirmPassword')) ? 'is-invalid' : '' ?>" id="confirmPassword" name="confirmPassword">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('confirmPassword')) ? $validate->getFirstError('confirmPassword') : '' ?> 
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>

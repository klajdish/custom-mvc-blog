
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">

            <h1><?= isset($user) || isset($user_id) ? 'Update User' : 'Create User' ?></h1>
            <form action="" method="post">
            <div class="mb-3">
                    <label for="role" class="form-label">Role Number</label>
                    <select name="role" id="role">
                        <option value="1" <?php echo (isset($user)) && $user->role==1 ? "selected" : '' ?>>Super Admin</option>
                        <option value="2" <?php echo (isset($user)) && $user->role==2 ? "selected" : '' ?>>Creater</option>
                        <option value="3" <?php echo (isset($user)) && $user->role==3 ? "selected" : '' ?>>Simple User</option>
                    </select>
                    <!-- <input type="number"  value="<?php echo (isset($user)) ? $user->role : '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('role')) ? 'is-invalid' : '' ?>"  id="role" name="role"> -->
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('role')) ? $validate->getFirstError('role') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">First name</label>
                    <input type="text"  value="<?php echo (isset($user)) ? $user->firstname : '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('firstname')) ? 'is-invalid' : '' ?>"  id="firstname" name="firstname">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('firstname')) ? $validate->getFirstError('firstname') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last name</label>
                    <input type="text" value="<?php echo (isset($user)) ? $user->lastname : '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('lastname')) ? 'is-invalid' : '' ?>" id="lastname" name="lastname">
                    <div class="invalid-feedback">
                        <?php echo (isset($validate) && $validate->getFirstError('lastname')) ? $validate->getFirstError('lastname') : '' ?> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" value="<?php echo (isset($user)) ? $user->email : '' ?>" class="form-control <?php echo (isset($validate) && $validate->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email">
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
                <button type="submit" class="btn btn-primary"><?= isset($user) || isset($user_id) ? 'Update' : 'Create' ?></button>
            </form>
        </div>
    </div>
</div>

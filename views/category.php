
<div class="p-5 mb-4 bg-light rounded-3 text-center">
      <div class="container-fluid py-5">
          <div class="row justify-content-center">
        <h1 class="display-5 fw-bold">Categories</h1>
        <p class="col-md-8 fs-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
              
          </div>
      </div>
    </div>

<div class="container">
    <div class="row justify-content-end">
        <div class="col-md-5">
            <form action="" method="GET">
                <div class="d-flex align-items-center justify-content-end" style="gap:30px">
                    <div>
                        <input type="text" placeholder="search" name="q">
                        <select name="category_id" id="category_id">
                            <option value="">Choose category</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?=$category->id ?>"<?=$category->id==$selectedId  ? 'selected' : '' ?> > <?=$category->name?></option>
                            <?php endforeach;?>
                        </select>

                    </div>

                    
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                
            </form>
            

        </div>
    </div> 
    
    <hr class="mb-5">

    <div class="row " >
		<?php foreach($allPosts as $post_id =>$value): ?>
            <div class="col-md-3 pb-5">
                <div class="card">
                    <img src="./upload/<?= $value['image_path']?>" class="card-img-top img-fluid" style="height:300px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-dark" href="/article?id=<?= $post_id?>" > <?= $value['title'] ?></a></h5>
                        <p class="card-text" style="height:90px"><?php if(strlen($value['description']) < 100){echo $value['description'];} else{ echo substr($value['description'],0,100).'...'; } ?>  <a href="/article?id=<?= $post_id?>"><?= strlen($value['description'])>100 ? "click here" : '' ?></a> </p>
                    </div>
                    <div class="card-footer text-muted small">
                        By <?=$value['user']?> 
                        In <a href="/category?category_id=<?=$value['category_id'] ?>" class="category_content"><?= $value['category'];  ?></a>
                        <p><?= date('jS M Y',strtotime($value['created_at']))?></p>
                    </div> 
                </div>
            </div>

        <?php endforeach; ?>   
    </div>
</div>


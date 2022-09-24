
<div class="container">
	<?php if(getFlash('middleware_error')): ?>
				<div class="row justify-content-center mt-3">
					<div class="col-md-12">
						<div class="card alert alert-danger">
							<?php echo getFlash('middleware_error')?>
						</div>
					</div>  
				</div>
	<?php endif; ?>

	<div class="jumbotron jumbotron-fluid mb-3 pt-0 pb-0 bg-lightblue position-relative">
		<div class="pl-4 pr-0 h-100 tofront">
			<div class="row justify-content-between">
				<div class="col-md-6 pt-6 pb-6 align-self-center">
					<h1 class="secondfont mb-3 font-weight-bold">PetBlog, Discover</h1>
					<p class="mb-3">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's book.
					</p>
					<a href="#" class="btn btn-dark">Read More</a>
				</div>
				<div class="col-md-6 d-none d-md-block pr-0" style="background-size:cover;background-image:url(./assets/images/1.jpg); background-position-y: center;">	</div>
			</div>
		</div>
	</div>
</div>

    
<div class="container pt-4 pb-4">
	<div class="row gx-5">
		<div class="col-lg-6 col-md-6">
			<div class="card border-0 mb-4 box-shadow h-xl-500">
				<h5 class="font-weight-bold spanborder"><span>Featured Post</span></h5>           
                <div style="background-image: url(/upload/<?= $allPosts['featuerdPost']['image_path'] ?>); height: 250px;    background-size: cover;    background-repeat: no-repeat;  background-position-y: center;"></div>               
				<div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
					<h2 class="h4 font-weight-bold">
						<a class="text-dark" href="/article?id=<?= $allPosts['featuerdPost']['id']?>" ><?= $allPosts['featuerdPost']['title'] ?></a>
					</h2>
					<p class="card-text"> <?= $allPosts['featuerdPost']['description'] ?> </p>
					<div class="card-text text-muted small">
						By <?=$allPosts['featuerdPost']['user']?>
						In <a href="/category?category_id=<?=$allPosts['featuerdPost']['category_id']?>" class="category_content"><?= $allPosts['featuerdPost']['category']?></a>
						<p><?= date('jS M Y',strtotime($allPosts['featuerdPost']['created_at']))?></p>	
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-6">
			<h5 class="font-weight-bold spanborder"><span>Popular</span></h5>
			<ol class="list-featured">
				<?php foreach($allPosts['popular'] as $post_id =>$value): ?>
					<li style="margin-bottom: 20px;">
						<span>
							<h6 class="font-weight-bold">
								<a href="/article?id=<?=$post_id ?>" class="text-dark" >
									<?= strlen($value['description']) < 70 ? $value['description'] : substr($value['description'],0,70).'...'?>
								</a>
							</h6>
							<p class="text-muted">
								By <?=$value['user']?> 
								In <a href="/category?category_id=<?=$value['category_id']?>" class="category_content"><?= $value['category'] ?></a>
							</p>
						</span>
					</li>
				<?php endforeach;?>
			</ol>
		</div>
	</div>
</div>
    
<div class="container">
	<div class="row justify-content-between">
		<div class="col-md-6">
			<h5 class="font-weight-bold spanborder"><span>All Stories</span></h5>
			<?php foreach($allPosts['all'] as $post_id =>$value): ?>
				<div class="mb-5 d-flex flex-column">
					<div class="pr-3" >
						<h2 class="mb-1 h4 font-weight-bold">
							<a class="text-dark" href="/article?id=<?= $post_id?>" ><?= $value['title']?></a>
						</h2>
						<p>
							<?= $value['description']?>
						</p>
						<div class="card-text text-muted small">
							By <?=$value['user']?> 
							In <a href="/category?category_id=<?=$value['category_id']?>" class="category_content"><?= $value['category']  ?></a>
							<p><?= date('jS M Y',strtotime($value['created_at']))?></p>
						</div>
					</div>
					<img class="img-fluid" style="max-width: 50%;" src="./upload/<?= $value['image_path']?>">
				</div>
			<?php endforeach;?>
			
			<?php if($pagination['numberOfPages']!=0): ?>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item <?= $pagination['currentPage']==1 ? 'disabled': '' ?>">
							<a class="page-link" href="?page=<?= $pagination['currentPage']!=1 ? $pagination['currentPage']-1 : '1' ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
								<span class="sr-only">Previous</span>
							</a>
						</li>
						<?php for($i=1; $i<=$pagination['numberOfPages'];$i++) : ?>
							<li class="page-item <?= $pagination['currentPage'] ==$i ? 'active' : ''?>"><a class="page-link"  href="?page=<?= $i?>"><?= $i?></a></li>
						<?php endfor; ?>

						<li class="page-item <?= $pagination['numberOfPages']==$pagination['currentPage'] || $pagination['numberOfPages']==1 ? 'disabled': '' ?>">
							<a class="page-link" href="?page=<?= $pagination['currentPage']!=$pagination['numberOfPages'] ? $pagination['currentPage']+1 : $pagination['currentPage'] ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
								<span class="sr-only">Next</span>
							</a>
						</li>
					</ul>
				</nav>
			<?php endif;?>
		</div>
		
		
		<div class="col-md-6 pl-4">
			<h5 class="font-weight-bold spanborder "><span>Categories</span></h5>
			<ol class="list-group list-group-numbered">
				<?php foreach($categories as $category_id => $value) :?>
					<a href="/category?category_id=<?=$category_id ?>">
						<li class="list-group-item d-flex justify-content-between align-items-start">
							<div class="ms-2 me-auto">
								<div class="fw-bold"><?= $categories[$category_id]['name']?></div>
							</div>
							<span class="badge bg-primary rounded-pill">
								<?= $categories[$category_id]['totalPosts'] ?>
							</span>
						</li>
					</a>
				<?php endforeach;?>
			</ol>		
		</div>
	</div>
</div>

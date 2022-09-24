<div class="container">
	<div class="jumbotron jumbotron-fluid mb-3 pl-0 pt-0 pb-0 bg-white position-relative">
		<div class="h-100 tofront">
			<div class="row justify-content-between">
				<div class="col-md-6 pt-6 pb-6 pr-6 align-self-center">
					<p class="text-uppercase font-weight-bold">
						<a href="/category?category_id=<?=$singlePost['category_id'] ?>" class="text-danger"><?= $singlePost['category']  ?></a>
					</p>
					<h1 class="display-4 secondfont mb-3 font-weight-bold"><?= $singlePost['title']?></h1>
					<p class="mb-3">
                        <?=$singlePost['description']?>
					</p>
					<div class="d-flex align-items-center">
						<small class="ml-2"><?= $singlePost['user']?>  <span class="text-muted d-block"><?= date('jS M Y',strtotime($singlePost['created_at']))?> &middot;</span></small>
					</div>
				</div>
				<div class="col-md-6 pr-0">
					<img src="./upload/<?= $singlePost['image_path']?> ">
				</div>
			</div>
		</div>
	</div>
</div>
    

<div class="container pt-4 pb-4">

	<?php if(isLoggedIn()): ?>
		<div class="row justify-content-center p-5 border">
			<div class="col-md-12 ">
				<form action="/article?id=<?=$singlePost['id']?>" method="POST">
					<h2 class="title_h2">Leave a comment</h2>
					<textarea placeholder='Add Your Comment' name="content" class="<?php echo (isset($validate) && $validate->hasError('content')) ? 'is-invalid' : '' ?>"></textarea>
					<div class="invalid-feedback">
						<?php echo (isset($validate) && $validate->getFirstError('content')) ? $validate->getFirstError('content') : '' ?> 
					</div>
					<div class="btn-div">
						<input type="submit" value='Comment'>
					</div>
				</form>
				<button id='clear' class="clear-button" style="float:right">Cancel</button>
			</div>
		</div>
	<?php endif ?>

	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card overflow-auto border-primary" style="max-height: 300px;" >
				<ul class="list-group list-group-flush ">
					<?php $count =0 ?>
						<?php foreach($comments as $comment_id => $parent): ?>
							<?php if($parent['status']==1 && is_null($parent['parent_id'])){ ?>
								<?php $count++ ?>
								<li class="list-group-item border"> 
									<?= '<b>'.$parent['user_name']. "</b>: ". $parent['content'] ?>  
									<?php foreach($comments as $comment_id2 => $child): ?>
										<?php if($parent['id'] == $child['parent_id'] && $child['status']==1	 ){ ?>
											<ul class="list-group list-group-flush ">
												<li class="list-group-item ps-5"> <?= '<b>'.$child['user_name']. "</b>: ". $child['content'] ?> </li>
											</ul>
										<?php } ?>
									<?php endforeach; ?>
									
									<?php if(isLoggedIn()): ?>
										<form action="/article?id=<?=$singlePost['id']?>&parent_id=<?=$comments[$comment_id]['id']?>" method="POST">
											<div class="d-flex " style="gap:10px">
												<input type="text" class="border input-reply" style="width:100%; padding:3px" name="content" placeholder="Reply to this comment">
												<button class="btn btn-primary reply-button" style="padding: 3px;font-size: 15px;">Reply</button>
											</div>
										</form>
									<?php endif;?>
								</li>
							<?php }; ?>
						<?php endforeach; ?>
					<?php if(!$count || empty($comments)): ?>
						<li class="list-group-item text-center">  No comments added  </li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>


	<div class="row justify-content-center pt-4 mt-5">
		<div class="col-lg-2 pr-4 mb-4 col-md-2">
			<div class="sticky-top text-center">
				<div class="text-muted">
					Share this
				</div>
				<div class="share d-inline-block">
					<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
						<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
						<a class="a2a_button_facebook"></a>
						<a class="a2a_button_twitter"></a>
					</div>
					<script async src="https://static.addtoany.com/menu/page.js"></script>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<h5 class="font-weight-bold spanborder"><span>Read next</span></h5>
			<div class="card border-0 mb-4 box-shadow h-xl-300">
				
				<div class="d-flex" style="gap:20px">
					<img class="img img-fluid" src="./upload/<?= $readNextPost['image_path']?> " style="height: 300px; width: 300px">
					<div class="card-body px-0 pb-0 d-flex flex-column align-items-start">
						<h2 class="h4 font-weight-bold">
							<a class="text-dark" href="/article?id=<?= $readNextPost['id']?>"><?= $readNextPost['title']?></a>
						</h2>
						<p class="card-text">
							<?= $readNextPost['description']?>
						</p>
						<div class="card-text text-muted small">
							By <?=$readNextPost['user']?>
							In <a href="/category?category_id=<?=$readNextPost['category_id']?>" class="category_content"><?= $readNextPost['category']?></a>
							<p><?= date('jS M Y',strtotime($readNextPost['created_at']))?></p>	
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

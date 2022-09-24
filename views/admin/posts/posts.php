

<div class="card-body">
    <?php if(getFlash('error')): ?>
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card alert alert-danger">
                    <?php echo getFlash('error')?>
                </div>
            </div>  
        </div>
    <?php endif; ?>


    <?php if(getFlash('success')): ?>
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card alert alert-success">
                    <?php echo getFlash('success')?>
                </div>
            </div>  
        </div>
    <?php endif; ?>

    <a href="/admin/post/add" class="btn btn-primary float-right mb-3"> Add Post</a>
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr class="text-center">
                <th >ID</th>
                <th>User Id</th>
                <th>Title</th>
                <th>description</th>
                <th>image_path</th>
                <th>Category Name</th>
                <?php if(isLoggedIn()->role==1): ?>
                    <th>featured</th>
                    <th>popular</th>
                <?php endif ?>
                <th>created_at</th>
                <th>updated_at</th>
                <th>operations</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post):?>
            <tr>
                <td><?= $post->id?></td>
                <td><?= $post->user_id?></td>
                <td><?= $post->title?></td>
                <td> <?= $post->description?></td>
                <td><?= $post->image_path?></td>
                <td><?= $categories[$post->category_id]['name'] ?></td>
                <?php if(isLoggedIn()->role==1): ?>
                    <td><?= $post->featured?></td>
                    <td><?= $post->popular?></td>
                <?php endif ?>
                <td><?= $post->created_at?></td>
                <td><?= $post->updated_at?></td>

                <td style="vertical-align: middle">
                    <div class="text-center d-flex justify-content-between" style="vertical-align: middle; gap:5px">
                        <a href="<?php echo URLROOT ?>/article?id=<?=$post->id?>" target="_blank"><button class="btn btn-primary"> View</button> </a>
                        <a href="<?php echo URLROOT ?>/admin/post/update?id=<?=$post->id?>"><button class="btn btn-warning"> update</button> </a>
                        <a href="<?php echo URLROOT ?>/admin/post/delete?id=<?=$post->id?>" onclick="return confirm('Are you sure you want to delete this item')" class="btn btn-danger"> delete</a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
    </table>

    <?php if(isset($pagination)): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination mt-4 ">
                <li class="page-item <?= $pagination['currentPage']==1 ? 'disabled': '' ?>">
                    <a class="page-link" href="?q=<?=$q?>&page=<?= isset($pagination) && $pagination['currentPage']!=1 ? $pagination['currentPage']-1 : '1' ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php for($i=1; $i<=$pagination['numberOfPages'];$i++) : ?>
                    <li class="page-item <?= $pagination['currentPage'] ==$i ? 'active' : ''?>"><a class="page-link"  href="?q=<?=$q?>&page=<?= $i?>"><?= $i?></a></li>
                <?php endfor; ?>

                <li class="page-item <?= $pagination['numberOfPages']==$pagination['currentPage'] || $pagination['numberOfPages']==1 ? 'disabled': '' ?>" >
                    <a class="page-link" href="?q=<?=$q?>&page=<?= isset($pagination) && $pagination['currentPage']!=$pagination['numberOfPages'] ? $pagination['currentPage']+1 : $pagination['currentPage'] ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>




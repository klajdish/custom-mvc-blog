

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



    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>ID</th>
                <th>Post Id</th>
                <th>Post Name</th>
                <th>Content</th>
                <th>User Id</th>
                <th>User Name</th>
                <th>Parent Id</th>
                <th>Status</th>
                <th>Created At</th>

        </thead>
        <tbody>
            <?php foreach($comments as $comment):?>
            <tr>
                <td><?= $comment->id?></td>
                <td><?= $comment->post_id?></td>
                <td><?= $data[$comment->id]['postname']?></td>
                <td><?= $comment->content?></td>
                <td><?= $comment->user_id?></td>
                <td><?= $data[$comment->id]['username']?></td>
                <td><?= $comment->parent_id?></td>
                <td><?= $comment->status?></td>
                <td><?= $comment->created_at?></td>
                <?php if( isLoggedIn()->role == 1 || (isLoggedIn()->role == 2 && $comment->user_id == isLoggedIn()->id)): ?>
                    <td>
                        <div class="text-center">
                            <a href="<?php echo URLROOT ?>/admin/comment/update?id=<?=$comment->id?>"><button class="btn btn-warning"> update</button> </a>
                            <a href="<?php echo URLROOT ?>/admin/comment/delete?id=<?=$comment->id?>" onclick="return confirm('Are you sure you want to delete this item')" class="btn btn-danger"> delete</a>
                        </div>
                    </td>
                <?php endif; ?>

            </tr>

            <?php endforeach;?>
    </table>

    <?php if($pagination['numberOfPages']!=0): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination mt-4 ">
                <li class="page-item <?= $pagination['currentPage']==1 ? 'disabled': '' ?>">
                <a class="page-link" href="?q=<?=$q?>&page=<?= $pagination['currentPage']!=1 ? $pagination['currentPage']-1 : '1' ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <?php for($i=1; $i<=$pagination['numberOfPages'];$i++) : ?>
                    <li class="page-item <?= $pagination['currentPage'] ==$i ? 'active' : ''?>"><a class="page-link"  href="?q=<?=$q?>&page=<?= $i?>"><?= $i?></a></li>
                <?php endfor; ?>

                <li class="page-item <?= $pagination['numberOfPages']==$pagination['currentPage'] || $pagination['numberOfPages']==1 ? 'disabled': '' ?>" >
                <a class="page-link"  href="?q=<?=$q?>&page=<?= $pagination['currentPage']!=$pagination['numberOfPages'] ? $pagination['currentPage']+1 : $pagination['currentPage'] ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
    

</div>



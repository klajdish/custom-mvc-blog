

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

<a href="category/add" class="btn btn-primary float-right mb-3"> Add Category</a>
    <table id="example2" class="table table-bordered ">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>description</th>
        </thead>
        <tbody>
            <?php foreach($categories as $category):?>
            <tr>
                <td><?= $category->id?></td>
                <td><?= $category->name?></td>
                <td><?= $category->description?></td>
                <td>
                    <div class="text-center">
                        <a href="<?php echo URLROOT ?>/admin/category/update?id=<?=$category->id?>"><button class="btn btn-warning"> update</button> </a>
                        <a href="<?php echo URLROOT ?>/admin/category/delete?id=<?=$category->id?>" onclick="return confirm('Are you sure you want to delete this item')" class="btn btn-danger"> delete</a>
                    </div>
                </td>
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



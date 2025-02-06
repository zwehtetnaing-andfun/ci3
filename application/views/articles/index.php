
<div class="container">
    <div class="row">
        <div class="col-md-12 my-5 d-flex justify-content-between align-items-center">
            <div class="">
                <h2>Articles</h2>

            </div>
            <div class=""><a href="<?= base_url('article/create')  ?>" class="btn btn-primary">Create</a></div>
        </div>
        <?php foreach($articles as $article): ?>
        <div class="col-md-8 mx-auto card mb-2">
            <div class="card-header">
                <h5><?= $article['title']; ?></h5>
            </div>
            <div class="card-body">
                <p class="text-muted"><?= $article['content']; ?></p>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="<?= base_url('article/edit')."/".$article['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                <a href="<?= base_url('article/delete')."/".$article['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- 
	::NOTE::
	base_url() methods will be surFix with base_url configuration
-->


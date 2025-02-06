<div class="container">
    <div class="row">
        <div class="col-md-8 card mx-auto my-5">
            <div class="card-header">
                <h5>Create Article</h5>
            </div>
            <div class="card-body">
				<?= form_open('article/store'); ?> // use form helper function

                    <div class="form-group mb-2">
                        <label for="title">Title</label>
                        <input type="input" name="title" class="form-control form-control-sm" >
                    </div>

                    <div class="form-group mb-2">
                        <label for="content">Content</label>
                        <textarea name="content" class="form-control form-control-sm" cols="45" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

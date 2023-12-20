<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <form method="post" id="forms" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="form-label">Title</label>
                <input type="text" class="form-control task-desc" name="title"
                    value="<?php echo isset($jobDetails['title']) ? $jobDetails['title'] : ''; ?>">

            </div>
            <div class="mb-4">
                <label class="form-label">Description</label>
                <input type="text" class="form-control task-desc" name="description"
                    value="<?php echo isset($jobDetails['description']) ? $jobDetails['description'] : ''; ?>">

            </div>
            <div class="mb-4">
                <label class="form-label">Company</label>
                <input type="text" class="form-control task-desc" name="company"
                    value="<?php echo isset($jobDetails['company']) ? $jobDetails['company'] : ''; ?>">

            </div>
            <div class="mb-4">
                <label class="form-label">Location</label>
                <input type="text" class="form-control task-desc" name="location"
                    value="<?php echo isset($jobDetails['location']) ? $jobDetails['location'] : ''; ?>">

            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <input type="text" class="form-control task-desc" name="status"
                    value="<?php echo isset($jobDetails['status']) ? $jobDetails['status'] : ''; ?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Date de création</label>
                <input type="date" class="form-control task-desc" name="date_created"
                    value="<?php echo isset($jobDetails['date_created']) ? $jobDetails['date_created'] : ''; ?>">
            </div>
           
<div class="form-group">
  

    <label>Update Image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image_path" accept="image/*" id="image_path_input">
        <label class="custom-file-label" for="image_path_input">
            <?php echo !empty($jobDetails['image_path']) ? $jobDetails['image_path'] : 'Choisir un fichier'; ?>
        </label>
    </div>
</div>


            <div class="d-flex w-100 justify-content-center">
                <button type="submit" class="btn btn-success btn-block mb-4 me-4 save">Save Edit</button>
                <a href="?route=dashboard"><div class="btn btn-danger btn-block mb-4 annuler">Annuler</div></a>
            </div>
        </form>
    </div>

    <script>
 
    document.getElementById('image_path_input').addEventListener('change', function () {
        var fileName = this.files[0].name;
        document.querySelector('.custom-file-label').textContent = fileName;
    });
</script>
</body>

</html>
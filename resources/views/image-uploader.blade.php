<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader</title>

    <!-- Bootstrap (opsional, biar rapi) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>

    <style>
        body {
            background: #f5f6fa;
        }

        .upload-area {
            border: 2px dashed #999;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 12px;
            cursor: pointer;
        }

        .upload-area.dragover {
            border-color: #007bff;
            background: #e9f5ff;
        }

        #preview-container {
            display: none;
            margin-top: 20px;
        }

        #preview {
            max-width: 100%;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Upload & Crop Gambar</h2>

    <!-- AREA DRAG & DROP -->
    <div id="upload-area" class="upload-area">
        <h5>Tarik gambar ke sini atau klik untuk memilih</h5>
        <p class="text-muted">Format: JPG, PNG — Maks 5MB</p>

        <input type="file" id="file-input" accept="image/*" hidden>
    </div>

    <!-- PREVIEW + CROP -->
    <div id="preview-container">
        <h5 class="mt-4 fw-semibold">Preview & Crop</h5>
        <img id="preview">

        <button class="btn btn-primary mt-3" id="upload-btn">
            Upload
        </button>
    </div>

    <!-- Hasil -->
    <div id="result" class="alert alert-success mt-4 d-none">
        Gambar berhasil diupload!
    </div>

</div>

<!-- JS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<!-- File JS Kamu -->
<script src="{{ asset('js/imageUploader.js') }}"></script>

</body>
</html>

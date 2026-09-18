@extends('layouts.home')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/css/trainersCardsLightTheme.css') }}">

    <style>
        /* Header Styles */
        header {
            margin-bottom: 30px;
            text-align: center;
            padding: 1.5rem;
        }

        h1 {
            color: #ffffff;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }

        h1 i {
            color: var(--primary);
            margin-right: 10px;
        }

        .subtitle {
            color: var(--gray-light);
            font-size: 1.1rem;
            margin-bottom: 25px;
        }


        /* upload image style */
        .upload-container {
            border: 3px dashed #ccc;
            border-radius: 12px;
            padding: 55px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #f8fafc;
            margin-bottom: 20px;
            margin: 2px;
        }

        .upload-container.has-image {
            border: 5px solid #2ecc71;
            padding: 15px;
        }


        .image-preview_edit {
            width: 100%;

            position: relative;
            margin-top: 20px;
        }

        .image-preview {
            width: 100%;
            display: none;
            position: relative;
            margin-top: 20px;
        }


        .upload-icon {
            font-size: 50px;
            color: #3498db;
            margin-bottom: 15px;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: rgba(255, 0, 0, 1);
            transform: scale(1.1);
        }

        #uploaded_img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 8px;
        }


        .upload-label {
            font-weight: 600;
            color: #555;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }

        .upload-label:hover {
            color: #3498db;
        }

        #item_img {
            display: none;
        }



        .instructions {
            background-color: #e8f4fc;
            border-left: 4px solid #3498db;
            padding: 15px;
            border-radius: 4px;
            margin-top: 25px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div style="padding: 1rem; background-color: #2a2525">


        <header>
            <h1><i class="fas fa-user-tie"></i> Add New Trainer </h1>
        </header>
        <form id="productForm" action="{{ route('trainer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Email</label>
                    <input name="email" id="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Phone </label>
                    <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone') }}"
                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



            </div>


            <div class="form-row">
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                        value="{{ old('date_of_birth') }}" placeholder="">
                    @error('date_of_birth')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}"
                        placeholder="">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="member-type">status </label>
                    <select class="form-control" name="status" id="status">
                        <option value="{{ old('status') }}"> select</option>
                        <option @if (old('status') == 1) selected="selected" @endif value='1'>
                            Active</option>
                        <option @if (old('status') == 0 or old('status') != '') selected="selected" @endif value='0'>
                            Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="member-type">Gender </label>
                    <select class="form-control" name="gender" id="gender">
                        <option value="{{ old('gender') }}"> select</option>
                        <option @if (old('gender') == 'male') selected="selected" @endif value="male">
                            Male</option>
                        <option @if (old('gender') == 'female' and old('gender') != '') selected="selected" @endif value="female">
                            Female</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>





            <div class="form-row">
                <div class="form-group">
                    <label>Height</label>
                    <input type="number" name="height" id="height" class="form-control" value="{{ old('height') }}"
                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                    @error('height')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Weight</label>
                    <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight') }}"
                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                    @error('weight')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nationality</label>
                    <input name="nationality" id="nationality" class="form-control" value="{{ old('nationality') }}">
                    @error('nationality')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="upload-container" id="uploadContainer">
                <div id="emptyState">
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <p style="color: black">Drag & drop your image here or click to browse</p>
                </div>

                <div class="image-preview" id="imagePreview">
                    <button type="button" class="remove-btn" id="removeBtn" title="Remove image">
                        <i class="fas fa-times"></i>
                    </button>
                    <img src="#" alt="Uploaded image" id="uploaded_img">
                </div>

                <label for="item_img" class="upload-label">
                    <span class="btn btn-accent">
                        <i class="fas fa-upload me-2"></i>Select Image
                    </span>
                </label>
                <input type="file" id="item_img" name="item_img" accept="image/*">
            </div>

            <div class="form-actions" style="justify-content: center; ">
                <a href="{{ route('trainer.index') }}" class="btn btn-danger">
                    <i class="fas fa-times-circle"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        /* ----------------------------    upload image -----------------------------*/
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('item_img');
            const uploadedImg = document.getElementById('uploaded_img');
            const imagePreview = document.getElementById('imagePreview');
            const emptyState = document.getElementById('emptyState');
            const removeBtn = document.getElementById('removeBtn');
            const uploadContainer = document.getElementById('uploadContainer');

            const existingImageInput = document.getElementById('existing_image');

            const removeImageInput = document.getElementById('remove_image');

            const profileForm = document.getElementById('profileForm');

            /* // Store the original image source
            const originalImageSrc = uploadedImg.src;
            let imageRemoved = false; */

            // Store the original image source
            const originalImageSrc = uploadedImg.src;
            const hasExistingImage = originalImageSrc && !originalImageSrc.endsWith('#');

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        uploadedImg.src = e.target.result;
                        emptyState.style.display = 'none'; //emptyState.classList.add('hidden');
                        imagePreview.style.display = 'block';
                        uploadContainer.classList.add('has-image');

                        // If user selects a new image after removing, reset the remove flag
                        removeImageInput.value = '0';
                        imageRemoved = false;

                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });


            // Handle remove button click
            removeBtn.addEventListener('click', function() {
                fileInput.value = '';
                uploadedImg.src = '#';
                imagePreview.style.display = 'none';
                emptyState.style.display = 'block';
                uploadContainer.classList.remove('has-image');

                // Set flag to indicate user wants to remove the image
                removeImageInput.value = '1';
                imageRemoved = true;

            });


            // Add drag and drop functionality
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#3498db';
                this.style.backgroundColor = '#e3f2fd';
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                if (!this.classList.contains('has-image')) {
                    this.style.borderColor = '#ccc';
                    this.style.backgroundColor = '#f8fafc';
                }
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#2ecc71';
                this.style.backgroundColor = '#f8fafc';

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;

                    // Trigger the change event manually
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });


        });
        /* --------------------- ---------------------------------------------------*/
    </script>
@endsection

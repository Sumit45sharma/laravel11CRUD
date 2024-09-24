<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Laravel 11 CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple laravel 11 CRUD</h3>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-xl-end">
                <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a></a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg my-4">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">edit product</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" action="{{ route('products.update',$product->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form label h5">Name</label>
                            <input value="{{ old('name', $product->name) }}" type="text" class="@error('name') is-invalid @enderror
                            form-control-lg form-control" placeholder="Name" name="name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="" class="form label h5">Password</label>
                            <input value="{{ old('password', $product->password) }}" type="password" class="@error('name') is-invalid @enderror
                            form-control form-control-lg" placeholder="Password" name="password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form label h5">Price</label>
                            <input value="{{ old('price', $product->price) }}" type="number" class="@error('name') is-invalid @enderror
                            form-control form-control-lg" placeholder="price" name="price">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form label h5">Discription</label>
                            <textarea textarea class="form-control " placeholder="Discription" name="discription"
                                cols="30" rows="5">{{ old('description', $product->discription) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form label h5">Image</label>
                            <input type="file" class="form-control form-control-lg" placeholder="Image" name="image">
                            @if ($product->image != "")
                                <img class="w-50 my-3" src="" {{ asset('uploads/products/' . $product->image)}}>
                            @endif
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-lg btn bg-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

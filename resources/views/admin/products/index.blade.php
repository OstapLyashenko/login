@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="text-center">{{__('Products')}}</h3>
            </div>
            <div class="col-md-12">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{session('status')}}
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <table class="table align-self-center">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Thumbnail</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="text-center" scope="col">{{$productq->id}}</td>
                            <td class="text-center" scope="col"> {{Storage::url($product->thumbnail)}} </td>
                            <td class="text-center" scope="col"><td>{{$product->price}}</td></td>
                            <td class="text-center" scope="col">{{$product->in_stock}}</td>
                            <td class="text-center" scope="col">
                            @include('categories.parts.category_view', ['category' => $product->category])
                            </td>
                            <td class="text-center" scope="col">
                                <a href="{{route('admin.products.edit', $product) }}" class="btn btn-info form-control">Edit</a>
                                <from action="{{ route('admin.product.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger form-control" value="Remove">
                                </from>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{$products->links() }}
    </div>
@endsection

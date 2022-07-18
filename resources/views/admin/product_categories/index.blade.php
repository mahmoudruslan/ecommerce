@extends('layouts.admin.master')
@section('title')
    index
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Ptoduct Categories</h6>
            <div class="ml-auto">
                <a class="btn btn-primary" href="{{ route('admin.product_categories.create') }}">
                    <span class="icon text-weight-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new category</span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <th>Name</th>
                <th>Ptoducts count</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Created at</th>
                <th style="width: 30px" class="text-center">Actions</th>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->products_count}}</td>
                        <td>{{$category->parent->name ?? '-'}}</td>
                        <td>{{$category->status}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admin.product_categories.edit', $category->id)}}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{route('admin.product_categories.edit', $category->id)}}" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty                  
                    <tr>
                        <td colspan="6" class="text-center">Not categories found</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="float-right">{!! $categories->links() !!}</div>
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>
@endsection

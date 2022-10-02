@extends('admin.layouts.app')
@section('title' , translate('Categories'))

@section('content')
    <ul class="nav nav-tabs nav-fill border-light">
        @foreach (\App\Models\Language::all() as $key => $language)
            <li class="nav-item">
                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                    href="{{ route('blog-category.edit', [$cateogry->id ,  'lang' => $language->code]) }}">
                    <img src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                        class="mr-1">
                    <span>{{ $language->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Blog Category Information') }}</h5>
                </div>
                <div class="card-body">
                    <form id="add_form" class="form-horizontal"
                        action="{{ route('blog-category.update', [$cateogry->id , 'lang' => $lang]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="category_name"
                                    name="category_name" value="{{ $cateogry->getTranslation('category_name' , $lang) }}" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

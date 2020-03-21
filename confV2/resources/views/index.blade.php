@extends('extends.indexParent')

@section('content')

        <!-- +------------- START POSTS -------------+ -->
        <section class="allPosts">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            @include('miniViews.getPost')
        </section>
        <!-- +------------- END POSTS -------------+ -->
        <!-- +------------- START ADD POST -------------+ -->
        <section class="addPost">
            <div class="form">
                <i class="la la-close"></i>
                <form method="POST">
                    <div class="selectCategory">
                        <label>التصنيف</label>
                        <select name="category">
                            <option value="">...</option>
                            @foreach($allCat as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->catArab }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="textConf">
                        <textarea name="thePost" placeholder="اخرج ما بداخلك"></textarea>
                    </div>
                    <div class="sendIt">
                        <input class="addPostComment" type="submit" value="اضافة" />
                    </div>
                </form>
            </div>
        </section>
        <!-- +------------- END ADD POST -------------+ -->
        <!-- +------------- START FULL POST -------------+ -->
        <section class="fullPost">
            <i class="la la-close"></i>
            <div class="theFull">
            </div>
        </section>
        <!-- +------------- END FULL POST -------------+ -->

        <!-- +------------- START ERROR MSG -------------+ -->
        <section class="error">
        </section>
        <!-- +------------- END ERROR MSG -------------+ -->

@endsection
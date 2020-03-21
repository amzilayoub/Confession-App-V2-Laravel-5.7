@foreach($allPosts as $data)



<div style="border: 1px solid {{ $data['color'] }}" data-idPost="{{ $data['id'] }}" class="post">

    <div class="detailsPost">



        <h1 style="width: 200px;background-color: {{ $data['color'] }}">{{ $data['catArab'] }}</h1>

    </div>

    <div class="textPost">

        <div class="infoPost">

            <span>

                <span>{{ $data['created_at'] }}</span>

                <i class="la la-eye">{{ $data["countViews"] }}</i>

            </span>

        </div>



        <p>{{ mb_substr(substr($data['post'], 0, 300), 0, 120, 'utf-8') }}</p>

    </div>

    <div class="btnPost">

        @if($data["productLiked"] == 1)

            <i class="la la-heart-o isLiked">{{ $data["countLikes"] }}</i>

        @else

            <i class="la la-heart-o">{{ $data["countLikes"] }}</i>

        @endif

        <i class="la la-comment">{{ $data["countComments"] }}</i>

        <i class="la la-share"></i>

    </div>

</div>



@endforeach
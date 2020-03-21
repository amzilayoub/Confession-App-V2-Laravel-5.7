<div class="theFull showFullPost">
    <div style="border: 1px solid {{ $allData[0]['color'] }}" data-idpost="{{ $allData[0]['id'] }}" class="post">
        <div class="detailsPost">
            <h1  style="background-color: {{ $allData[0]['color'] }}">{{ $allData[0]['catArab'] }}</h1>
        </div>
        <div class="textPost">
            <div class="infoPost">
                <span>
                    <span>{{ $allData[0]['created_at'] }}</span>
                    <i class="la la-eye">{{ $allData[0]['countViews'] }}</i>
                </span>
            </div>
                <p>{{ $allData[0]['post'] }}</p>
        </div>
        <div class="btnPost">
            @if($allData[0]["productLiked"] == 1)
                <i class="la la-heart-o isLiked">{{ $allData[0]['countLikes'] }}</i>
            @else
                <i class="la la-heart-o">{{ $allData[0]['countLikes'] }}</i>
            @endif
            <i class="la la-comment">{{ $allData[0]['countComments'] }}</i>
            <i class="la la-share"></i>
        </div>
    </div>
    <div class="theComments">
        <div class="addComment">
            <form>
                <textarea name="comment"></textarea>
                <input class="addPostComment" type="submit" value="اضافة">
            </form>
        </div>
        <div class="allComment">
            @foreach($allComments as $comments)
                <h6>{{ $comments['comment'] }}</h6>
            @endforeach
        </div>
    </div>
</div>
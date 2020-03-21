<!DOCTYPE html>

<html lang="ar" dir="rtl">

    <head>

        <base href="/works/confV2/public/">

        <!-- Required meta tags -->

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- GOOGLE FONT -->

        <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

        <!-- FONT ICON -->

        <link rel="stylesheet" href="css/line-awesome.min.css">

        <!-- My Style -->

        <link rel="stylesheet" href="css/style.css" >

        <title>مرحبا بك في اعترافات</title>

        <!-- HTML 5 SHIV -->

        <script src="js/html5shiv.min.js"></script>

        <!-- RESPOND -->

        <script src="js/respond.min.js"></script>

    </head>

    <body>

        <!-- +------------- START NAVBAR -------------+ -->

        <section class="sideNavbar">

            <div class="showBar">

                <i class="la la-bars"></i>

            </div>

            <div class="brand">

                <i class="la la-comments"></i>

                <a href="#"><h6>اعترافات</h6></a>

            </div>

            <div class="navbar">

                <nav>

                    <ul>

                        <a href="/works/confV2/public/"><li class="activeLi"><i class="la la-home"></i><h6>الرئيسية</h6></li></a>

                        <a class="addOnClick" href="#"><li><i class="la la-list"></i><h6>التصنيف</h6></li></a>

                        <a class="addOnClick" href="most"><li><i class="la la-fire"></i><h6>الأكثر </h6></li></a>

                        <a href="privacy"><li><i class="la la-file-o"></i><h6>الخصوصية</h6></li></a>

                        <a class="addOnClick" href="#"><li><i class="la la-at"></i><h6>اتصل بنا</h6></li></a>

                    </ul>

                </nav>

            </div>

            <div class="addPostBtn">

                <h6><i class="la la-pencil-square"></i></h6>

            </div>

        </section>

        <!-- +------------- END NAVBAR -------------+ -->

        <!-- +------------- START CATEGORY -------------+ -->

        <section class="categories">

            <span class="closeCat"><i class="la la-close" aria-hidden="true"></i></span>

            <div class="allCategories">



                @foreach($allCat as $cat)

                    <div><a href="{{ $cat->id }}">{{ $cat->catArab }}</a></div>

                @endforeach



<!--                 <div><a href="?cat=dream">عن حلم</a></div>

                <div><a href="?cat=fantasy">في الخيال</a></div>

                <div><a href="?cat=firstExperience">أول تجربة</a></div>

                <div><a href="?cat=regret">ندم</a></div>

                <div><a href="?cat=pain">ألم</a></div>

                <div><a href="?cat=randomFel">مشاعر مبعثرة</a></div>

                <div><a href="?cat=real">حقيقة</a></div>

                <div><a href="?cat=hardExp">تجربة قاسية</a></div>

                <div><a href="?cat=other">أخرى</a></div> -->

            </div>

        </section>

        <!-- +------------- END CATEGORY -------------+ -->

        <!-- +------------- START SEARCH -------------+ -->

        <section class="search">

            <div class="searchForm">

                <form method="POST">

                    <input type="text" autocomplete="off" name="searchedPost" />

                    <i class="la la-search"></i>

                </form>

            </div>

        </section>

        <!-- +------------- END SEARCH -------------+ -->

        <!-- +------------- START CONTACT US -------------+ -->

        <section class="sideBarStyle contactAside">

            <div class="back">

                <i class="la la-arrow-right"></i>

            </div>

            <div class="contactUs">

                Contact Us

            </div>

            <form>

                <div>

                    <input type="text" name="firstName" placeholder="First Name" />

                </div>

                <div>

                    <input type="text" name="lastName" placeholder="Last Name" />

                </div>

                <div>

                    <input type="email" name="email" placeholder="Email" />

                </div>

                <div>

                    <input type="text" name="subject" placeholder="Subject" />

                </div>

                <div>

                    <textarea maxlength="1000" name="theMessage" placeholder="The Message"></textarea>

                </div>

                <div>

                    <input class="addPostComment" type="submit" value="ارسال" />

                </div>

            </form>

        </section>

        <!-- +------------- END CONTACT US -------------+ -->
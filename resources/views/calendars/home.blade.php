@extends('layouts.calendars')

@section('title', 'University of Edinburgh Calendars')

@section('content')

    @php
        $carouselImages = asset('collections/calendars/images/carousel');
        $carousel = [
            ['id' => '52833', 'file' => '0057313c.jpg', 'alt' => 'Civitates Orbis Terrarum Spice Route', 'caption' => 'October 15: Spice Route'],
            ['id' => '52834', 'file' => '0057317c.jpg', 'alt' => 'Civitates Orbis Terrarum Augsburg', 'caption' => 'November 15: Augsburg'],
            ['id' => '52835', 'file' => '0057322c.jpg', 'alt' => 'Civitates Orbis Terrarum Antwerp', 'caption' => 'December 15: Antwerp'],
            ['id' => '52836', 'file' => '0057331c.jpg', 'alt' => 'Civitates Orbis Terrarum Rhodes', 'caption' => 'January: Rhodes'],
            ['id' => '52837', 'file' => '0057312c.jpg', 'alt' => 'Civitates Orbis Terrarum Cairo', 'caption' => 'February: Cairo'],
            ['id' => '52838', 'file' => '0057325c.jpg', 'alt' => 'Civitates Orbis Terrarum London', 'caption' => 'March: London'],
            ['id' => '52839', 'file' => '0057332c.jpg', 'alt' => 'Civitates Orbis Terrarum Parma', 'caption' => 'April: Parma'],
            ['id' => '52840', 'file' => '0057334c.jpg', 'alt' => 'Civitates Orbis Terrarum Malta', 'caption' => 'May: Malta'],
            ['id' => '52841', 'file' => '0057323c.jpg', 'alt' => 'Civitates Orbis Terrarum Liege', 'caption' => 'June: Liege'],
            ['id' => '52842', 'file' => '0057318c.jpg', 'alt' => 'Civitates Orbis Terrarum Cologne', 'caption' => 'July: Cologne'],
            ['id' => '52843', 'file' => '0057320c.jpg', 'alt' => 'Civitates Orbis Terrarum Strasbourg', 'caption' => 'August: Strasbourg'],
            ['id' => '52844', 'file' => '0057329c.jpg', 'alt' => 'Civitates Orbis Terrarum Mexico', 'caption' => 'September: Mexico City'],
            ['id' => '52845', 'file' => '0057319c.jpg', 'alt' => 'Civitates Orbis Terrarum Frankfurt', 'caption' => 'October 16: Frankfurt'],
            ['id' => '52846', 'file' => '0057316c.jpg', 'alt' => 'Civitates Orbis Terrarum Milan', 'caption' => 'November 16: Milan'],
            ['id' => '52847', 'file' => '0057335c.jpg', 'alt' => 'Civitates Orbis Terrarum Famagusta', 'caption' => 'December 16: Famagusta'],
        ];
    @endphp

    <div class="record">
        <div class="content byEditor">
            <h1 class="laing">University Calendar 2016: Images from the Georg Braun&#39;s <i>Cities Of The World</i></h1>

            <div class="jcarousel-wrapper">
                <div class="jcarousel" data-jcarousel="true">
                    <ul style="left: 0; top: 0;">
                        @foreach($carousel as $item)
                            <li><a href="./record/{{ $item['id'] }}">
                                    <img alt="{{ $item['alt'] }}" title="{{ $item['alt'] }}" src="{{ $carouselImages }}/{{ $item['file'] }}">
                                    <div class="carousel-caption caption-iog" onmouseover="this.style.background='#c78c86';this.style.color='#ffffff'" onmouseout="this.style.background='#872379';this.style.color='#FFFFFF'">
                                        {{ $item['caption'] }}
                                    </div>
                                </a></li>
                        @endforeach
                    </ul>
                </div>

                <a class="jcarousel-control-prev" href="#" data-jcarouselcontrol="true">&lsaquo;</a>
                <a class="jcarousel-control-next" href="#" data-jcarouselcontrol="true">&rsaquo;</a>
            </div>

            <div class="info">
                <p>The images displayed in this calendar are taken from the Civitates Orbis Terrarum (Shelfmark: *P.15.33), a city atlas edited by the geographer Georg Braun and engraved by the
                    painter Franz Hogenberg between 1572 and 1617. This fantastic work contains 546 prospects, bird&rsquo;s-eye views and maps of cities from all over the world. Aside from their topographical value,
                    the images are also a great record of domestic life during the period: figures in local dress were added to the maps, along with heraldic coats of arms, rural and urban scenes, public buildings and
                    pictures of land and water transport. These depictions were accompanied by Braun&rsquo;s printed account of the city&rsquo;s history, situation and commerce.</p>
                <p>
                    Buy online at the University
                    <a href="http://www.giftshop.ed.ac.uk/2016-library-university-collections-calendar.html" target="_blank" title="Gift Shop Link">gift shop<span class="sr-only"> (opens in a new tab)</span></a>.
                </p>
            </div>

            <div class="spacer">
                &nbsp; &nbsp;&nbsp; &nbsp;
            </div>

            <div class="signature">
                <img alt="Calendar 2016" title="Calendar 2016" src="{{ asset('collections/calendars/images/Calendar2016-front.jpg') }}">
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
@endsection

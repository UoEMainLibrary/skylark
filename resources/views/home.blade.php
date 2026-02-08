@extends('layouts.app')

@section('title', 'Home - University of Edinburgh Collections')

@section('content')
<div class="tab-list">
    <div class="container">
        <div class="row">
            <h1 class="tab-h2">Online Collections</h1>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/archives.jpg') }}" alt="Archives">
                    <div>
                        <h2 class="img-title"><span>Archives</span> Online<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://archives.collections.ed.ac.uk/" title="Archives" target="_blank">
                            <span class="sr-only">Archives Online (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>
            <div class="col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/art.jpg') }}" alt="Art Collection"/>
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Art</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/art" title="Art Collection" target="_blank">
                            <span class="sr-only">Art Collection (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/mimed.jpg') }}" alt="Musical Instruments">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Musical</span> Instruments<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/mimed" title="Musical Instruments" target="_blank">
                            <span class="sr-only">Musical Instruments (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/iconics.jpg') }}" alt="Iconics Collection">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Iconics</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/iconics" title="Iconics Collection" target="_blank">
                            <span class="sr-only">Iconics Collection (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>
        </div>
    </div>
</div>

<div class="tab-col">
    <div class="container-full">
        <div class="row">
            <figure class="clickbox">
                <img src="https://images.is.ed.ac.uk/luna/servlet/iiif/UoEwmm~2~2~56057~103607/117,350,3802,570/800,/0/default.jpg"
                    alt="Laing Collection, Treasures Room" class="img-responsive">
                <div>
                    <h2 class="img-title centered">Collections as Data</h2>
                    <i class="ion-arrow-right-c"></i>
                    <div class="curl"></div>
                    <a href="{{ url('/collections-as-data') }}" class="caption" title="Collections as Data"></a>
                </div>
            </figure>
        </div>
    </div>
</div>

<div class="tab-col">
    <div class="container-full">
        <div class="row">
            <figure class="clickbox">
                <img src="{{ asset('images/0016491cropped.jpg') }}"
                    alt="Robert Barker, Panorama of Edinburgh, 1792" class="img-responsive">
                <div>
                    <h2 class="img-title centered"><span class="fa fa-file-pdf-o"></span>Directory of Collections</h2>
                    <i class="ion-arrow-right-c"></i>
                    <div class="curl"></div>
                    <a href="https://collections.ed.ac.uk/directory" class="caption"
                       title="View the University of Edinburgh Collections Directory"></a>
                </div>
            </figure>
        </div>
    </div>
</div>

<div class="tab-list2">
    <div class="container">
        <div class="row">
            <h1 class="tab-h2">Digital Image Collections</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/anatomy.jpg') }}" alt="Anatomy Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Anatomy</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcha~4~4" title="Anatomy Collection" target="_blank" >
                            <span class="sr-only">Anatomy Collection (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/architectural.jpg') }}" alt="Architectural Drawings" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span class="longword">Architectural</span> Drawings<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcar~3~3" title="Architectural Drawings" target="_blank" >
                            <span class="sr-only">Architectural Drawings (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/carmichael.jpg') }}" alt="Carmichael Watson" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Carmichael</span> Watson<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcar~1~1" title="Carmichael Watson" target="_blank" >
                            <span class="sr-only">Carmichael Watson (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/shakespeare.jpg') }}" alt="Shakespeare" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Early</span> English Drama<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEsha~1~1" title="Early English Drama" target="_blank" >
                            <span class="sr-only">Early English Drama (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/rarebooks.jpg') }}" alt="ECA Rare Books">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>ECA Rare</span> Books<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEwmm~3~3" title="ECA Rare Books" target="_blank" >
                            <span class="sr-only">ECA Rare Books (opens in a new tab)</span>
                        </a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/ecaphotography.jpg') }}" alt="ECA Photography Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>ECA Photography</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEecp~1~1" title="ECA Photography Collection" target="_blank" >
                            <span class="sr-only">ECA Photography Collection (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/geology.jpg') }}" alt="Geology and Geologists" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Geology and Geologists<span class="fa-solid fa-up-right-from-square"></span></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEsha~5~5" title="Geology and Geologists" target="_blank" >
                            <span class="sr-only">Geology and Geologists (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/hillandadmson.jpg') }}" alt="Hill and Adamson" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Hill and Adamson</span> photography<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcar~4~4" title="Hill and Adamson" target="_blank" >
                            <span class="sr-only">Hill and Adamson (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/incunabula.jpg') }}" alt="Incunabula" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Incunabula</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEgal~2~2" title="Incunabula" target="_blank" >
                            <span class="sr-only">Incunabula (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/laing.jpg') }}" alt="Laing Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Laing</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEwmm~2~2" title="Laing Collection" target="_blank" >
                            <span class="sr-only">Laing Collection (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/maps.jpg') }}" alt="Maps Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Maps</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcha~1~1" title="Maps Collection" target="_blank" >
                            <span class="sr-only">Maps Collection (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/museums.jpg') }}" alt="Museums Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Museums</span> Collections<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEhal~2~2" title="Museums Collection" target="_blank" >
                            <span class="sr-only">Museums Collection (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/newcollege.jpg') }}" alt="New College" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>New College</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEsha~3~3" title="New College" target="_blank" >
                            <span class="sr-only">New College (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/orientalmanuscripts.jpg') }}" alt="Oriental Manuscripts" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Oriental</span> Manuscripts<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEsha~4~4" title="Oriental Manuscripts" target="_blank" >
                            <span class="sr-only">Oriental Manuscripts (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/roslin.jpg') }}" alt="Roslin Institute" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Roslin</span> Institute<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEgal~6~6" title="Roslin Institute" target="_blank" >
                            <span class="sr-only">Roslin Institute (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/salvesen.jpg') }}" alt="Salvesen" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Salvesen</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEcar~2~2" title="Salvesen" target="_blank" >
                            <span class="sr-only">Salvesen (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/uoeppe.jpg') }}" alt="University of Edinburgh - People, Places &amp; Events" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>University</span> People, Places &amp; Events<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEgal~4~4"
                           title="University of Edinburgh - People, Places &amp; Events" target="_blank" >
                            <span class="sr-only">University of Edinburgh - People, Places &amp; Events (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/uoeteaching.jpg') }}" alt="Edinburgh University Image Teaching Collections Home" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>University</span> Teaching Collections<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images-teaching.is.ed.ac.uk/luna/servlet"
                           title="Edinburgh University Image Teaching Collections Home" target="_blank" >
                            <span class="sr-only">Edinburgh University Image Teaching Collections Home (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/walterscott.jpg') }}" alt="Walter Scott Collection" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Walter Scott</span> Collection<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEwal~1~1" title="Walter Scott Collection" target="_blank" >
                            <span class="sr-only">Walter Scott Collection (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/wmmanuscripts.jpg') }}" alt="Western Medieval Manuscripts" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Western Medieval</span> Manuscripts<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://images.is.ed.ac.uk/luna/servlet/UoEwmm~1~1" title="Western Medieval Manuscripts" target="_blank" >
                            <span class="sr-only">Western Medieval Manuscripts (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>
        </div>
    </div>
</div>

<div class="tab-list3">
    <div class="container">
        <div class="row">
            <h1 class="tab-h2">Digitisation Projects</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/Atiz.jpg') }}" alt="Scottish Session Papers" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Court of Scottish Session Papers</span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="{{ url('/csp') }}" title="Court of Scottish Session Papers"></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/IMG_0506.jpg') }}" alt="Mahabharata Scroll" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span>Mahabharata Scroll</span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="{{ url('/mahabharata') }}" title="Mahabharata Scroll"></a>
                    </div>
                </figure>
            </div>
        </div>
    </div>
</div>

<div class="tab-list4">
    <div class="container">
        <div class="row">
            <h1 class="tab-h2">Additional Collection Resources</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/carmichaelwatsonproject.jpg') }}" alt="Carmichael Watson" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span class="glyphicon glyphicon-camera"></span><span>Carmichael Watson</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="http://www.carmichaelwatson.lib.ed.ac.uk/cwatson/" title="Carmichael Watson Project" target="_blank" >
                            <span class="sr-only">Carmichael Watson Project (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/fairbairn.jpg') }}" alt="Fairbairn" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span>Fairbairn</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="http://www.fairbairn.ac.uk/" title="Fairbairn" target="_blank">
                            <span class="sr-only">Fairbairn (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/lhsa.jpg') }}" alt="LHSA Case Notes" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span>LHSA Case Notes</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/lhsacasenotes" title="LHSA Case Notes" target="_blank" >
                            <span class="sr-only">LHSA Case Notes (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/towardsdolly.jpg') }}" alt="Towards Dolly" class="img-responsive">
                    <div>
                        <h2 class="img-title"><span>Towards Dolly</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/towardsdolly" title="Towards Dolly" target="_blank">
                            <span class="sr-only">Towards Dolly (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/alumni.jpg') }}" alt="Alumni">
                    <div>
                        <h2 class="img-title"><span>Historical Alumni</span> Database<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/alumni" title="Alumni" target="_blank">
                            <span class="sr-only">Alumni (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/guardbook.jpg') }}" alt="Guardbook">
                    <div>
                        <h2 class="img-title"><span class="fa fa-file-pdf-o"></span><span>Guardbook</span> Historic Library Catalogue<span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://collections.ed.ac.uk/guardbook" title="Guardbook" target="_blank">
                            <span class="sr-only">Guardbook (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/0014770c.jpg') }}" alt="Tobar an Dualchais Collection">
                    <div>
                        <h2 class="img-title"><span>Tobar an Dualchais</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                        <i class="fa fa-sound"></i>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="http://www.tobarandualchais.co.uk/" title="Tobar an Dualchais" target="_blank">
                            <span class="sr-only">Tobar an Dualchais (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/era.jpg') }}" alt="Theses Collection in Edinburgh Research Archive">
                    <div>
                        <h2 class="img-title"><span class="fa fa-file-pdf-o"></span><span>PhD Theses</span> Collection<span class="fa-solid fa-up-right-from-square"></span> </h2>
                        <i class="ion-arrow-right-c"></i>
                        <div class="curl"></div>
                        <a href="https://www.era.lib.ed.ac.uk/browse?value=PhD+Doctor+of+Philosophy&type=type" title="Theses Collection in Edinburgh Research Archive" target="_blank">
                            <span class="sr-only">Theses Collection in Edinburgh Research Archive (opens in a new tab)</span></a>
                    </div>
                </figure>
            </div>
        </div>
    </div>
</div>

<div class="tab-visit collapseGroup" id="collapseGroup1">
    <div class="container-full">
        <div class="row title-image">
            <a href="#visitus" data-toggle="collapse" data-parent="#collapseGroup1" title="Visit Us">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/visitus-new.jpg') }}" alt="Visit Us"/>
                    <div>
                        <h2 class="img-title centered"><span  class="visitus-special">Visit Us</span></h2>
                        <i class="ion-minus"></i>
                        <i class="ion-plus"></i>
                        <div class="curl"></div>
                    </div>
                </figure>
            </a>
        </div>
    </div>
    <div class="tab8 collapse" id="visitus">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/exhib.jpg') }}" alt="Exhibitions"/>
                        <div>
                            <h4 class="img-title"><span>Exhibitions</span></h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://exhibitions.ed.ac.uk"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/crc.jpg') }}" alt="Center for Research Collections"/>
                        <div>
                            <h4 class="img-title"><span>Centre</span> for <span>Research Collections</span></h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/stcecilias.jpg') }}" alt="St Cecilia's Hall"/>
                        <div>
                            <h4 class="img-title"><span>St Cecilia's</span> Hall</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="http://www.stcecilias.ed.ac.uk"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/talbotrice.jpg') }}" alt="Talbot Rice Gallery"/>
                        <div>
                            <h4 class="img-title"><span>Talbot Rice</span> Gallery</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/talbot-rice/"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/anatomymuseum.jpg') }}" alt="Anatomy Museum"/>
                        <div>
                            <h4 class="img-title"><span>Anatomy</span> Museum</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/biomedical-sciences/anatomy/visit-anatomical-museum"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/scottishstudies.jpg') }}" alt="School of Scottish Studies Archives"/>
                        <div>
                            <h4 class="img-title"><span>School of Scottish Studies</span> Archives</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://collections.ed.ac.uk/participate"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/newcollegelibrary.jpg') }}" alt="New College Library"/>
                        <div>
                            <h4 class="img-title"><span>New College</span> Library</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://collections.ed.ac.uk/participate"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/exhibitions.jpg') }}" alt="Cockburn Geological Museum"/>
                        <div>
                            <h4 class="img-title"><span>Cockburn</span> Geological Museum</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/geosciences/about/history/museum"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/nathist.jpg') }}" alt="Natural History Collection"/>
                        <div>
                            <h4 class="img-title"><span>Natural History</span> Collection</h4>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="http://www.nhc.ed.ac.uk"></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-participate collapseGroup" id="collapseGroup2">
    <div class="container-full">
        <div class="row title-image">
            <a href="#participate" data-toggle="collapse" data-parent="#collapseGroup2" title="Participate">
                <figure class="clickbox">
                    <img src="{{ asset('images/clickboxes/0024681c.jpg') }}" alt="Participate"/>
                    <div>
                        <h2 class="img-title centered"><span>Participate</span></h2>
                        <i class="ion-minus"></i>
                        <i class="ion-plus"></i>
                        <div class="curl"></div>
                    </div>
                </figure>
            </a>
        </div>
    </div>
    <div class="tab9 collapse" id="participate">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/libraryblogs.jpg') }}" alt="Library Blogs"/>
                        <div>
                            <h2 class="img-title"><span>Library </span> Blogs<span class="fa-solid fa-up-right-from-square"></span></h2>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="http://libraryblogs.is.ed.ac.uk/" title="Library BLogs" target="_blank">
                                <span class="sr-only">Library BLogs (opens in a new tab)</span>
                            </a>
                        </div>
                    </figure>
                </div>
                <div class="col-md-6 col-sm-6  col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/donate.jpg') }}" alt="Donate"/>
                        <div>
                            <h2 class="img-title"><span>Donate</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/transfers-donations"
                               title="Donate" target="_blank">
                                <span class="sr-only">Donate (opens in a new tab)</span>
                            </a>
                        </div>
                    </figure>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/volunteering.jpg') }}" alt="Volunteering"/>
                        <div>
                            <h2 class="img-title"><span>Volunteering</span><span class="fa-solid fa-up-right-from-square"></span></h2>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/skills-volunteers-interns-fellowships/volunteers-interns" title="Volunteering" target="_blank">
                                <span class="sr-only">Volunteering (opens in a new tab)</span>
                            </a>
                        </div>
                    </figure>
                </div>
                <div class="col-md-6 col-sm-6  col-xs-12">
                    <figure class="clickbox">
                        <img src="{{ asset('images/clickboxes/metadatagames.jpg') }}" alt="Metadata Games"/>
                        <div>
                            <h2 class="img-title"><span>Metadata</span> Games<span class="fa-solid fa-up-right-from-square"></span></h2>
                            <i class="ion-arrow-right-c"></i>
                            <div class="curl"></div>
                            <a href="https://librarylabs.ed.ac.uk/" title="Metadata Games" target="_blank">
                                <span class="sr-only">Metadata Games (opens in a new tab)</span></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

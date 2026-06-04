@extends('layouts.jlss')

@section('title', 'Jewish Lives Scottish Spaces')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">

    <div id="index-blurb">
        <p alt="SJAC site blurb">
        SJAC’s diverse collections include old <abbr data-title="Synagogue: Jewish place of worship.">Synagogue</abbr> minute books and registers, membership lists, photographs, oral histories,
        testimonies, annual reports of communal organisations, books of Scottish Jewish interest, friendly society regalia, personal
        papers, war medals, ceremonial keys, newspapers, magazines, trophies, plaques, paintings and sculptures, immigration and
        naturalisation papers, passports and correspondence.

        We also hold copies of records of all of the 17 Jewish cemeteries in Scotland, indexed on our computer database.

        We have a computer database of almost 40,000 Scottish Jews. Information is constantly being added to this database, which
        includes information from over 70 sources such as cemetery lists, <abbr data-title="Synagogue: Jewish place of worship.">synagogue</abbr> registers, charity subscription lists and census
        records.
        </p>
    </div>

    <h1 alt="SJAC Jewish Lives, Scottish Spaces Collections list">Collections</h1>
    <div class="content-divider-index"><p>divider</p></div>

    <div class="row">
            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/theatre-clickbox.jpg') }}"
                            alt="Link to the Theatre Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3><span><br>Theatre</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;theatre+%7C%7C%7C+Theatre&quot;" title="Link to the Theatre Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/serving-clickbox.jpg') }}" alt="Link to the Serving Their Country Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span >Serving <br>Their Country</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;serving+their+country+%7C%7C%7C+Serving+Their+Country&quot;" title="Link to the Serving Their Country Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/migration-clickbox.jpg') }}" alt="Link to the Migration Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Migration</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;migration+%7C%7C%7C+Migration&quot;" title="Link to the Migration Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/refugee-clickbox.jpg') }}" alt="Link to the Refugee Period Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Refugee Period</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;refugee+period+%7C%7C%7C+Refugee+Period&quot;" title="Link to the Refugee Period Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/religion-clickbox.jpg') }}" alt="Link to the Religious Life Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Religious Life</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;religious+life+%7C%7C%7C+Religious+life&quot;" title="Link to the Religious Life Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/art-clickbox.jpg') }}" alt="Link to the Art Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Art</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;art+%7C%7C%7C+Art&quot;" title="Link to the Art Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/soviet-clickbox.jpg') }}" alt="Link to the Soviet Jewry Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Soviet Jewry</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;soviet+jewry+%7C%7C%7C+Soviet+Jewry&quot;" title="Link to the Soviet Jewry Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/community-clickbox.jpg') }}" alt="Link to the Scottish Communities Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span>Scottish <br>Jewish Communities</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;scottish+communities+%7C%7C%7C+Scottish+Communities&quot;" title="Link to the Scottish Communities Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/women-clickbox.jpg') }}" alt="Link to the Women Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span><br>Women</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;women+%7C%7C%7C+Women&quot;" title="Link to the Women Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="col-sm-3 col-md-4 col-sm-6 col-xs-12">
                <div class="clickbox-margin">
                    <figure class="clickbox">
                        <img src="{{ asset('collections/jlss/images/clickboxes/relations-clickbox.jpg') }}" alt="Link to the Wider Relations Collection" class="img-responsive">

                        <div class="clickbox-text">
                            <div class="clickbox-text-background">
                                <h3 alt="Collection title"><span>Relations with the<br>Wider Community</span></h3>
                                <i class="fa fa-camera"></i>
                                <i class="ion-arrow-right-c"></i>
                            </div>

                            <div class="curl"></div>
                            <a href="./search/*:*/Collection:&quot;relations+with+wider+community+%7C%7C%7C+Relations+with+wider+community&quot;" title="Link to the Wider Relations Collection"></a>
                        </div>
                    </figure>
                </div>
            </div>
    </div>

    </div>
<div class="col-sidebar">
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav">
        <ul class="list-group">
            <li class="list-group-item active">
                <a href="./browse/Collection" alt="sidae bar facet link" title="Click to view all Collections">Collection</a>
            </li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;theatre+%7C%7C%7C+Theatre&quot;">Theatre</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;serving+their+country+%7C%7C%7C+Serving+Their+Country&quot;">Serving Their Country</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;migration+%7C%7C%7C+Migration&quot;">Migration</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;refugee+period+%7C%7C%7C+Refugee+Period&quot;">Refugee Period</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;religious+life+%7C%7C%7C+Religious+life&quot;">Religious Life</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;art+%7C%7C%7C+Art&quot;">Art</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;soviet+jewry+%7C%7C%7C+Soviet+Jewry&quot;">Soviet Jewry</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;scottish+communities+%7C%7C%7C+Scottish+Communities&quot;">Scottish Communities</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;women+%7C%7C%7C+Women&quot;">Women</a></li>
            <li class="list-group-item"><a href="./search/*:*/Collection:&quot;relations+with+wider+community+%7C%7C%7C+Relations+with+wider+community&quot;">Relations with the Wider Community</a></li>
        </ul>
    </div>
</div>
</div>
@endsection

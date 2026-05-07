@extends('layouts.lhsacasenotes')

@section('title', 'Achievements - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="content byEditor">
        <h1 class="itemtitle">&lsquo;&hellip; the work that I have at heart&rsquo; &ndash; Norman Dott and neurosurgery</h1>

        <p>Aneurysms occur when weakness in the walls of veins or arteries cause a &lsquo;bulge&rsquo; when blood passes through them.
            This can result in bleeding, a haemorrhage, when the walls of the vessel rupture. Norman Dott secured
            his place in medical history by a pioneering 1931 operation to treat an intracranial aneurysm
            by direct surgical intervention into an area called the Circle of Willis, a loop of arteries at the base of
            the brain. Since these arteries sit near the brainstem, through which the nerves that connect the brain to
            the motor and sensory systems of the rest of the body pass, operating in this area carried a great deal of
            potential risk in the early days of Dott&rsquo;s ground-breaking surgeries.</p>

        <img src="{{ asset('collections/lhsacasenotes/images/LHB1-CC24-PR1-682d.gif') }}" alt="Royal Infirmary of Edinburgh" class="img-responsive pull-left gap-right img-rounded" />

        <p>The operation was carried out on a middle-aged patient whom Dott described as a
            &lsquo;personal friend and benefactor&rsquo;. Dott wrapped the area of the aneurysm with muscle from the patient&rsquo;s leg
            in order to strengthen the blood vessel walls where they were thinning dangerously. Weary of seeing patients
            die from brain haemorrhages, post-mortem observations had led Dott to realise that brain haemorrhages could
            sometimes heal themselves by blood-clots that stemmed further leakage, and that surgery could perhaps &lsquo;reinforce
            Nature&rsquo;s attempt at healing&rsquo; through providing another form of &lsquo;scaffolding&rsquo;. Although he was advised against
            surgical intervention for fear of fatality (for medical specialisms such as neurosurgery in their relative
            infancy could ill afford a high mortality rate), the operation was a success, with the patient&rsquo;s only complaint
            being a pain in his leg from where the muscle graft was taken!</p>

        <p>In order to treat aneurysms of the carotid artery, Dott practised tying (ligation) of arteries, shutting off
            blood-flow to the aneurysm, a practice that he pioneered in 1932, just a year after his aneurysm wrapping
            operation. The process of detecting aneurysms was considerably aided in 1933, when Dott was the first to
            demonstrate an aneurysm by means of angiography, an x-ray technique that involved operating on the patient
            under anaesthetic to expose the artery, injecting it with a dye and subsequently taking x-ray films.</p>

        <p>Yet another breakthrough was to come in the midst of the Second World War, when Dott performed an operation
            on a foreign forces&rsquo; patient. The patient had an aneurysm in the anterior communicating artery, a small vessel
            which carries blood from one side of the brain to another - a common site for aneurysm formation and difficult
            to access without causing further haemorrhage. Dott decided that it would be safer to put a clip on the larger
            artery which was feeding the smaller anterior communicating artery &ndash; this could be done without disturbing
            the aneurysm, which had already ruptured. Although the operation itself was not without risk, the patient&rsquo;s
            case file reveals that he was &lsquo;up after five days&hellip; in excellent condition and fit for discharge.&rsquo;</p>

        <p>Dott&rsquo;s work in the diagnosis and treatment of intracranial aneurysms was both pioneering and wide-ranging &ndash;
            weighing up the risk to each patient, treatment was advised accordingly. In some cases of aneurysm Dott
            recognised that the surgical risk (and even the risk of exposing arteries through angiography) was unwarranted
            when it was possible for the body to repair itself through rest and recuperation.</p>
        <p>Dott's contributions to medicine went beyond his immediate specialism: in his work in developing anaesthesia
            from 1918 to 1920, he experimented with intratracheal techniques; he published on the malrotation of the
            intestine in the neonate; and wrote studies on the dislocation of the hip. No doubt due to his background in
            engineering, Norman Dott was also skilled in the development and improvement of surgical devices, designing
            his own instruments and equipment, including the &ldquo;Dott Slow Occlusion Carotid Artery Clamp&rdquo; in 1935. Other
            designs included a fine needle holder used for anastomosing facial nerves in the depths of the cranium, a
            headpiece for accurate positioning of the operation site for facial surgery, a sterilisable gun for making and
            delivering metal surgical clips, and malleable needles for passing ligatures round the necks of aneurysms.
            Dott also had strong interests in pain management and in developing facilities and techniques for post-operative
            rehabilitation.</p>
    </div>
</div>

@include('lhsacasenotes.partials.sidebar')
@endsection

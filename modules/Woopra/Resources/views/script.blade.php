<!-- Start of Woopra Code -->
@php $user = auth()->user(); @endphp
<script>
    (function(){
        var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call","trackForm","trackClick"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
    })("woopra");

    woopra.config({
        domain: "{{ str_replace(['http://', 'https://'], [], env('APP_URL')) }}",
        ignore_query_url: false,
        outgoing_tracking: true
    });

    woopra.identify({
        name: "{{ $user->name }}",
        email: "{{ $user->email }}",
        company: "{{ setting('general.company_name') }}",
        avatar: "https://www.gravatar.com/avatar/<?php echo md5(strtolower($user->email)); ?>&amp;size=60"
    });

    woopra.track();
</script>
<!-- End of Woopra Code -->
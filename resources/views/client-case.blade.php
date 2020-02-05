@extends('layouts.app')

@section('content')
<div id="case_summary">

</div>
@endsection

<script>
    let summary = {!! json_encode($summary->toArray(), JSON_HEX_TAG) !!};
    window.setTimeout(() => {
        console.log([document.querySelector('#case_summary')])
        document.querySelector('#case_summary').innerHTML = summary[0]['case_summary']
    }, 1000)

</script>

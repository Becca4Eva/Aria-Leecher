@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('messages.gband') (BETA! I WILL ADD SO MANY THINGS HERE LATER!!!)</div>
                <div class="panel-body">
                    <h4>General Info:</h4><legend></legend>
                    <div id="area" class="epoch category10" style="height: 200px;"></div>
                    <hr />
                    <table style="width:100%" class="ud">
                        <thead>
                        <tr>
                            <th style="width: 20%"></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Global Speed:</td>
                            <td id="speed" class="bld">{{ $main->formatBytes($aria2->getGlobalStat()['result']['downloadSpeed'], 3) }}/s</td>
                        </tr>
                        <tr>
                            <td>Active Downloads:</td>
                            <td id="numActive" class="bld">{{ $aria2->getGlobalStat()['result']['numActive'] }}</td>
                        </tr>
                        <tr>
                            <td>Stopped Downloads:</td>
                            <td id="numStopped" class="bld">{{ $aria2->getGlobalStat()['result']['numStopped'] }}</td>
                        </tr>
                        <tr>
                            <td>Waiting:</td>
                            <td id="numWaiting" class="bld">{{ $aria2->getGlobalStat()['result']['numWaiting'] }}</td>
                        </tr>
                    </table><br /><br />
                    <h4>Detailed Info:</h4><legend></legend>
                    <table style="width:100%" class="uds">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <?php $gos = $aria2->getGlobalOption() ?>
                        @foreach($gos['result'] as $key => $go)
                            <tr>
                                <td>{{str_replace('-',' ', $key)}}:</td>
                                <td class="bld">{{ $go }}</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script>


        $(function() {
            var c = [{
                label: "Series B",
                values: [ {time: (new Date).getTime()/ 1000, y: 0}]
            }];

            var chart = $('#area').epoch({
                type: 'time.area',
                data: c,
                axes: ['left', 'right', 'bottom']
            });


            setInterval(function(){
                $.ajax({
                    url: "",
                    type: "post",
                    data: "_token={{ csrf_token() }}",
                    dataType: 'json',

                    success: function (response) {
                        $('#speed').html(response.speed + '/s');
                        $('#numActive').html(response.numActive);
                        $('#numStopped').html(response.numStopped);
                        $('#numWaiting').html(response.numWaiting);

                        chart.push([{
                            time: response.time,
                            y: parseInt(response.speed_b)
                        }]);
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("The following error occurred: " + textStatus, errorThrown);
                    }
                })
            }, 1000);

        });
//        chart.push(data.next());
    </script>

@endsection

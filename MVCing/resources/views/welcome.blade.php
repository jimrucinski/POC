<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        
    </head>
    <body>
        <ul>
        <!--this is blade syntax-->
        @foreach($tasks as $task)
        <li>{{$task}}</li>
        @endforeach
        </ul>

    </body>
</html>

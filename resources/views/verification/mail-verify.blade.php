@extends('layouts.app')

@section('content')
    <div class="flex-center full-height position-ref">
        <div class="alert m-b-md @if($status) success @else error @endif">
            <div class="title">{{ $message }}</div>
            <p>
                <small class="sub">
                    将在<span id="count-down">10</span>后跳转至首页。
                    如果没有跳转，您也可以点击<a href="{{ route('index') }}">此处</a>跳转
                </small>
            </p>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
      let countDown = document.getElementById('count-down');
      let counter = setInterval(function () {
        if (countDown.innerText <= 1) {
          clearInterval(counter);
          window.location.href = '{{ route('index') }}';
        }
        countDown.innerText--;
      }, 1000);

    </script>
@endsection

@section('styles')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: Helvetica, Tahoma, Arial, STXihei, "华文细黑", Heiti, "黑体", "Microsoft YaHei", "微软雅黑", SimSun, "宋体", sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .alert {
            letter-spacing: .1rem;
            padding: .75rem 1.25rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            text-align: center;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .title {
            font-size: 2.5rem;
        }

        .sub {
            color: #6c757d !important;
        }

        .sub > a {
            font-weight: 600;
            color: inherit;
            padding: 0 .5rem;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <br>
                            <h2>Verification</h2>
                            <p>To add your own lorcana card to the site the user must be verified. View <a href="/posts">two lorcana cards</a>. After you're verified
                                you will be able to add/edit/delete your own lorcana card.</p>
                                <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3">Go to Lorcana library</a>
                            <br>
                            <div class="card">
                            <img src="https://cdn.discordapp.com/attachments/1149613606909005917/1185666161334046760/pic7036898.webp?ex=659070a9&is=657dfba9&hm=ca4da42cf83c01dd4c50b272b2de5834a32f32d93a340bca87ce8bbe9da1ef5b&">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

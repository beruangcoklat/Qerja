@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <style>
        #close-chat{
            background: rgba(0, 0, 0, 0.4);
            z-index: 11;
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 74px;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('script')
    <script src="js/chat.js"></script>
@endsection

@section('content')
<div id="content">
    <div id="content-container">
        <div id="chat-room">
            <chat-message
                v-for="i in messages"
                v-bind:data="i"
            ></chat-message>
        </div>
        
        <div id="chat-input">
            <input type="text" id="txt-chat-input" >
            <button
                v-on:click="writeChat()"
            >Kirim</button>
        </div>
    </div>
    @include('modal.chatAdmin')
    
    <div id="close-chat" v-show="!adminExists">
        <img src="image/NoAdmin.jpg">
    </div>
</div>

@include('modal.modalHome')
@endsection
<div id="chat-list-btn" 
	v-on:click="showChatList = true"
	v-if="vNav.role == 'admin'"
>
	<img src="image/chat.png">
</div>

<div id="chat-list-container" 
	v-show="showChatList"
	v-on:click="showChatList = false"
>
	<div id="chat-list">
		<div class="chat-list-item" 
			v-for="data in contacts"
			v-on:click="changeChat(data.id)"
		>
			<div><img v-bind:src="'image/user/' + data.image"></div>
			<div><p>@{{ data.name }}</p></div>
		</div>
	</div>
</div>

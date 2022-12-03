import chatRoutes from "@/modules/chat/routes";

import HomePage from "@/modules/chat/pages/HomePage.vue";

import TheChat from "@/modules/chat/Components/TheChat.vue";
import ChatMessage from "@/modules/chat/Components/ChatMessage.vue";
import MessageBox from "@/modules/chat/Components/MessageBox.vue";
import UsersList from "@/modules/chat/Components/UsersList.vue";
import UsersListItem from "@/modules/chat/Components/UsersListItem.vue";

import { useChatStore } from "@/modules/chat/stores/ChatStore";

export {
    HomePage,
    chatRoutes,
    useChatStore,
    ChatMessage,
    MessageBox,
    TheChat,
    UsersList,
    UsersListItem,
};

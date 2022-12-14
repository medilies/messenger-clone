import axios from "axios";
import { authorizationHeader } from "@/modules/auth";

const authenticatedPost = (path, message, additionalHeaders = {}) => {
    return axios.post(path, message, {
        headers: {
            ...authorizationHeader(),
            ...additionalHeaders,
        },
    });
};

const authenticatedGet = (path, additionalHeaders = {}) => {
    return axios.get(path, {
        headers: {
            ...authorizationHeader(),
            ...additionalHeaders,
        },
    });
};

const sendMessage = (message, conversationId) => {
    return authenticatedPost(
        `/api/chat/conversations/${conversationId}/messages`,
        message
    );
};

export { authenticatedPost, authenticatedGet, sendMessage };

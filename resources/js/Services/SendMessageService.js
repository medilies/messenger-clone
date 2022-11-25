import axios from "axios";
import authorizationHeader from "./AuthorizationHeaderService";

const sendMessage = (message) => {
    return axios.post("/api/messages", message, {
        headers: authorizationHeader(),
    });
};

export default sendMessage;

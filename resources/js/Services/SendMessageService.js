import axios from "axios";
import authorizationHeader from "./AuthorizationHeaderService";

const sendMessage = (message) => {
    return axios.post("/api/messages", message, {
        headers: {
            accept: "application/json",
            // ...authorizationHeader(),
        },
    });
};

export default sendMessage;

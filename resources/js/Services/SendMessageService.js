import axios from "axios";
import authorizationHeader from "./AuthorizationHeaderService";

const sendMessage = (message) => {
    return axios.post("/api/messages", message, {
        headers: {
            Accept: "application/json",
            // ...authorizationHeader(),
        },
    });
};

export default sendMessage;

import authorizationHeader from "./AuthorizationHeaderService";
import BaseAxios from "./BaseAxios";

const sendMessage = (message) => {
    return BaseAxios.post("/messages", message, {
        headers: authorizationHeader(),
    });
};

export default sendMessage;

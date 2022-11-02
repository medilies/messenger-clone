const sendMsg = (message) => {
    axios.post("/api/messages", { message }).then((response) => {
        console.log(response.data);
    });
};

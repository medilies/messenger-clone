Echo.channel("home").listen("NewMessage", (e) => console.log(e));

const sendMsg = (message) => {
    axios.post("/messages", { message }).then((response) => {
        console.log(response.data);
    });
};

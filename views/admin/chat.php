<?php 
use app\core\Application;
$_session=Application::$app->session;
$_user=$_session->get('user');
?>
<div class="container">
    <div class="chat-app">
        <div class="d-md-flex height-10">
            <div class="col-md-3 height-100 py-2">
                <div id="plist" class="people-list">
                    <div class="input-group search-area right d-lg-inline-flex people-search">
                        <input type="text" class="form-control" onkeyup="userSearch()" id="search-on-user" placeholder="ابحث هنا ....">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon-search"></i>
                            </span>
                        </div>
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0" id="user-chat-list">
                        <!--  -->
                        <!--  -->
                    </ul>
                </div>
            </div>
            <div class="col-md-9 height-100 py-2">
                <div class="chat p-2 d-none" id="chat-user-content">
                    <div class="chat-header clearfix">
                        <div class="d-flex align-items-center border-bottom2 pb-2">
                            <a href="javascript:void(0);">
                                <img src="/uploads/" id="chat-user-img">
                            </a>
                            <div class="chat-about mx-2">
                                <div class="name " id="chat-user-name"> </div>
                                <small id="chat-user-lvl"></small>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history">
                        <ul class="py-2" id="chat-content-items"></ul>
                    </div>
                    <div class="chat-message clearfix ">
                        <div class="input-group search-area right d-lg-inline-flex">
                            <input type="text" class="form-control" id="chat-message-content" placeholder="النص ....">
                            <div class="input-group-append" id="submit-sent-chat">
                                <span class="input-group-text">
                                    <i class="icon-chevron-left "></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //######[Search on User ]#########
    function userSearch() {
        // Declare variables
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('search-on-user');
        filter = input.value.toUpperCase();
        ul = document.getElementById("user-chat-list");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("name")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    }
    //###############
    function getUsers() {
        var chat_user_list = document.getElementById('user-chat-list');
        // Creating Our XMLHttpRequest object 
        let xhr = new XMLHttpRequest();
        xhr.open("GET", '/cp/chat/get-users', true);
        // function execute after request is successful 
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                if (data.users) {
                    (data.users).forEach(element => {
                        // console.log(element);
                        chat_user_list.innerHTML += `
                        <li class="align-items-center border-bottom2 user-lists" 
                            id="uu_${element.uid}" onClick="clickUser('${element.uid}','${element.name}','${element.img}','${element.lvl}')">
                            <img src="/uploads/${element.img}">
                            <div class="about mx-1">
                                <div class="name">${element.name}</div>
                                <small>${element.lvl}</small>
                            </div>
                        </li>`;
                    });
                }
            }
        }
        // Sending our request 
        xhr.send();
    }
    getUsers();

    // on click to user to show chat
    function clickUser(id, name = '', img = '', lvl = '') {

        document.getElementById('chat-user-content').classList.remove('d-none');

        document.getElementById('chat-user-name').innerHTML = name;
        document.getElementById('chat-user-lvl').innerHTML = lvl;
        document.getElementById("chat-user-img").src = "/uploads/" + img;
        var ulist = document.getElementsByClassName('user-lists');
        for (i = 0; i < ulist.length; i++) {
            ulist[i].classList.remove('active');
        }
        document.getElementById('uu_' + id).classList.add('active');
        //get user id
        const myid="<?=$_user['user_id']?>";
        //
        var chat_content_items = document.getElementById('chat-content-items');
        chat_content_items.innerHTML = "";
        //
        getChats(id,myid);
        //submit new chat
        const chatBtn = document.getElementById('submit-sent-chat');
        chatBtn.addEventListener("click", function (e) {
            e.preventDefault();
            addChats(id,myid);
        });

    }
    //get Chat
    function getChats(id,myid) {
        //
        const Date_options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZone: 'Asia/Baghdad' // Your local time zone
        };
        //
        var chat_content_items = document.getElementById('chat-content-items');
        //
        let fd = new FormData();
        fd.set('id', id);
        fd.set('myid', myid);
            //####################
            setInterval( ()=>{
            fetch("/cp/chat/get", {
                method: 'POST',
                body: fd
            }).then((response) => {
                return response.json();
            }).then((res) => {
                //
                if (res.chats) {
                    //
                    chat_content_items.innerHTML = " ";
                    //
                    (res.chats).forEach(element => {
                        //  console.log(element);
                        var data_time = new Date().getFullYear(element.created);

                        const dateObject = new Date(element.created * 1000);
                        const fullDateAndTime = dateObject.toLocaleString('en-US', Date_options);
                        //send from me
                        if (element.send_from == id) {
                            chat_content_items.innerHTML += `
                                <li class="clearfix">
                                    <div class="message-data text-left">
                                        <span class="message-data-time">${fullDateAndTime}</span>
                                    </div>
                                    <div class="message other-message float-left">${element.content}</div>
                                </li>`;
                        }
                        else {
                            //send to me
                            chat_content_items.innerHTML += `
                                <li class="clearfix">
                                    <div class="message-data">
                                        <span class="message-data-time">${fullDateAndTime}</span>
                                    </div>
                                    <div class="message my-message">${element.content}</div>
                                </li>`;
                        }
                    });
                    //
                    scrollBottom(chat_content_items);
                    //
                }
                //
            }).catch((error) => {
                console.log(error)
            })
        },2000);
            //###############

    }
    function addChats(id , myid){
        var inputValue = document.getElementById("chat-message-content");
        //
        let fd = new FormData();
        fd.set('send_from', myid);
        fd.set('send_to', id);
        fd.set('content', inputValue.value);

        fetch("/cp/chat/add", {
            method: 'POST',
            body: fd
        }).then((response) => {
            return response.json();
        }).then((res) => {
            //
            if(0 == res.error){
                // getChats(id);
            }
            else{
               alert(res.msg);
            }
            //
        }).catch((error) => {
            console.log(error)
        })
    }
    //scroll to end
    function scrollBottom(element) {
			element.scroll({top: element.scrollHeight})
		}

</script>
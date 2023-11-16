<style>
        .board__nav {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .board__nav ul {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 30vw;
            height: 50px;
        }
        .board__search .right {
            position: relative;
        }

        .board__nav li a {
            font-size: 0.8rem;
            margin: 0 2.5vw;
        }

        .board__nav:active {
            text-decoration: underline;
        }

        .board__table td {
            padding: 25px 5px;
            border-bottom: 1px solid #b3b3b3;
            text-align: center;
        }

        .board__search .left {
            margin-left: 30px;
            font-size: 0.8rem;
        }

        .board__view {
            margin: 0 auto;
            margin-top: 20px;
        }
        .board__view h3 {
            font-size: 1.1rem;
            padding: 20px 5px;
            border-bottom: 2px solid #009688;
            text-align: center;
            color: #30A99E;
            font-weight: 600;
        }
        .board__view i {
            font-style: normal;
        }
        .board__view .info {
            border-bottom: 1px solid #009688;
            font-size: 1.1rem;
            padding: 10px 15px;
            text-align: center;
            color: #30A99E;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
        }
        .blog__index {
            margin: 0 auto;
            padding: 10px 0;
            border-top: 1px solid #009688;
            border-bottom: 1px solid #009688;
            display: flex;
            align-items: center;
            justify-content: space-between;

        }
        .blog__index a {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 150px;
        }
        .board__view .contents {
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-between;
            padding: 15px 30px;
            height: 100%;
        }
        .board__view .contents span {
            font-size: 1rem;
            line-height: 1.8;
            margin: 0 auto;
        }
        .img__box {
            cursor: pointer;
            margin: 0 auto;
            height: 100%;
            overflow: hidden;
            margin-bottom: 10px;
            padding: 30px 0;
        }
        .img__box img {
            max-width: 60%;
            margin: 0 auto;
            height: auto;
            display: block;
        }
        .img__box p {
            font-size: 0.8rem;
            text-align: center;
        }
        .write__btn {
            text-align: center;
        }
        .board__btns a {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .board__title {
            margin-top: 0;
        }

        #blogLike {
            display: flex;
            justify-content: flex-end;
            margin: 0 auto;
            margin-top: 15px;
            align-items: center;
        }
        #blogLike p {
            padding:0 15px;
        }
        .like {
            cursor: pointer;
            background-image: url(../../assets/img/like.svg);
            width: 20px;
            height: 20px;
            background-size: cover;
            background-color: #fff0;   
        }
        .dislike {
            cursor: pointer;
            background-image: url(../../assets/img/like.svg);
            width: 20px;
            height: 20px;
            background-size: cover;
            background-color: #fff0; 
        }
        .selected {
            background-image: url(../../assets/img/like2.svg);
            width: 20px;
            height: 20px;
            background-size: cover;
            background-color: #fff0;
        }
        .selected2 {
            background-image: url(../../assets/img/dislike.svg);
            width: 20px;
            height: 20px;
            background-size: cover;
            background-color: #fff0;
        }
        .blog__comment {
            padding: 30px 0;
            margin: 0 auto;
        }

        .blog__comment h4 {
            width: 100%;
            color : #009688;
            font-size: 1.25rem;
            font-weight: 600;
            border-top: 2px solid #009688;
            border-bottom: 1px solid #009688;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }

        .comment__view {
            position: relative;
            margin-bottom: 20px;
        }

        .comment__view .avata img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center center;
            border: 1px solid var(--black400);
            background-color: #fff;
            position: absolute;
            left: 0;
            top: 0;
            transition : all 0.3s;
        }
        .comment__view .avata img:hover {
            transform : scale(3);
        }

        .comment__view:nth-child(even) .avata {
            left: auto;
            right: 0;
            transform: rotateY(180deg);
        }

        .comment__view:nth-child(even) .texts {
            text-align: right;
        }

        .comment__view:nth-child(even) .texts p {
            border-radius: 10px 0 10px 10px;
            text-align-last: left;
        }


        .comment__view .texts {
            margin-left: 60px;
            margin-right: 60px;
        }

        .comment__view .texts>span {
            display: block;
            font-size: 14px;
            color: var(--black300);
        }

        .comment__view .texts p {
            background-color: #fff;
            padding: 10px;
            border-radius: 0 10px 10px 10px;
            display: inline-block;
            margin-top: 4px;
        }

        .comment__view .texts .modify {
            text-decoration: underline;
            text-underline-position: under;
        }

        .comment__view .texts .modify:hover {
            color: var(--black)
        }

        .comment__view .texts .delete {
            text-decoration: underline;
            text-underline-position: under;
        }

        .comment__view .texts .delete:hover {
            color: var(--black)
        }

        .comment__input {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px dashed #009688;
        }

        .comment__input fieldset {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .comment__input #commentName {
            width: 49.5%;
        }

        .comment__input #commentPass {
            width: 49.5%;
        }

        .comment__input #commentWrite {
            width: 100%;
            margin-top: 10px;
        }

        #popupDelete {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10000;
        }

        .comment__delete {
            width: 300px;
            height: 400px;
            background-color: #F5F5F2;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 2px solid var(--black);
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 15px;
        }

        .comment__delete h4 {
            margin-bottom: 10px;
        }

        .comment__delete input {
            border: 1px solid var(--black400);
            padding: 1rem;
            width: 100%;
            font-size: 1rem;
        }

        .comment__delete p {
            margin-top: 10px;
            color: var(--black300);
        }

        .modify__btn2 {
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .modify__btn2 button {
            background-color: #30a99e;
            color: var(--white);
            padding: 5px 20px;
            cursor: pointer;
            border-radius: 5px;
        }


        #popupModify {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10000;
        }

        .comment__modify {
            width: 300px;
            height: 400px;
            background-color: #F5F5F2;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 2px solid var(--black);
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            border-radius: 15px;
        }

        .comment__modify h4 {
            margin-bottom: 10px;
        }

        .comment__modify textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 1rem;
            resize: none;
        }

        .comment__modify input {
            border: 1px solid var(--black400);
            padding: 1rem;
            width: 100%;
            font-size: 1rem;
        }

        .comment__modify p {
            height: 50px;
            margin-top: 10px;
            color: var(--black300);
        }

        .comment__modify .btn {
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .comment__modify .btn button {
            background-color: #285A5B;
            color: var(--white);
            padding: 5px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .none {
            display: none;
        }
        .input__style {
            width: 100%;
            background-color: #E6F2F1;
            padding: 16px 30px;
            border-radius: 10px;
            font-weight: 300;
            border: 0;
            font-size: 1rem;
        }
        .commentWriteBtn {
            margin-top: 10px;
            width: 70px;
            height: 30px;
            background-color: #30A99E;
            font-size: 0.8rem;
            color: #fff;
            border-radius: 25px;
            cursor: pointer;
        }
        #blogLike .like__box {
                display: flex;
        }
        /* 모달 스타일 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            max-width: 40%;
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }
        @media(max-width:1100px){
            .board__nav ul {
                width: 40vw;
            }
            .board__search .left {
                display: none;
            }
            .board__search {
                justify-content: flex-end;
            }

            .blog__comment,
            #blogLike ,
            .blog__index ,
            .board__view {
                width: 95%;
            }
        }
        @media(max-width:660px){
            .board__nav ul {
                width: 60%;
                height: 40px;
            }
            .board__search .right select {
                width: 100px;
                display: flex;
            }
            #blogLike {
                display: block;
            }
            .board__btns {
                justify-content: center;
            }
            #blogLike .like__box {
                justify-content: center;
            }
            .board__view .contents {
                padding: 0;
            }
            .modal-content {
                max-width: 100%;
            }
            .board__view .contents span {
                margin-bottom: 15px;
            }
            .write__btn {
                margin: 3px;
                height: 30px;
            }


        }
        
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="output.css">
    <!-- Jquery -->
    <script src="../js/jquery.js"></script>
    <!--Toastr-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <section class="bg-red-100 min-h-screen flex box-border justify-center items-center">
        <div class="bg-gradient-to-r from-indigo-100 via-purple-200 to-pink-300 rounded-2xl  md:flex md:max-w-3xl md:p-5 md:items-center">
            <div class="md:w-1/2 px-8">
            <img class="md:hidden mx-auto rounded-2xl w-[100px] h-[100px]" src="../image/logo.png" alt="login form image">
                <h2 class="font-bold text-3xl text-[#596b8a]">Login</h2>
                <p class="text-sm mt-4 text-[#002D74]">If you already a member, easily log in now.</p>

                <div class="flex flex-col gap-4">
                    <input id="mobile" class="p-2 mt-8 rounded-xl border" type="number" name="number" value="" placeholder="Mobile">
                    <div class="relative">
                        <input onkeypress="rdlogin(event);" id="password" class="p-2 rounded-xl border w-full" type="password" name="password" value="" placeholder="Password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" id="togglePassword"
                            class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer z-20 opacity-100"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                            </path>
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                            </path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye-slash-fill absolute top-1/2 right-3 -z-1 -translate-y-1/2 cursor-pointer hidden"
                            id="mama" viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z">
                            </path>
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z">
                            </path>
                        </svg>
                    </div>
                    <button class="bg-[#002D74] text-white py-2 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium" type="submit" onclick="login()">Login</button>
                </div>


                <div class="mt-10 text-sm border-b border-gray-500 py-5 playfair tooltip hover:text-blue-500 hover:text-[15px]">Forget password?</div>

                <div class="mt-4 text-sm flex justify-between items-center container-mr">
                    <p class="mr-3 md:mr-0 ">If you don't have an account..</p>
                    <button class="hover:border register text-white bg-[#002D74] hover:border-gray-400 rounded-xl py-2 px-5 hover:scale-110 hover:bg-[#002c7424] font-semibold duration-300">Register</button>
                </div>
            </div>
            <div class="md:block hidden w-1/2">
                <img class=" rounded-2xl max-h-[1600px]" src="../image/logo.png" alt="login form image">
            </div>
        </div>
    </section>
    <script>
        function rdlogin(event){
            if(event.key=="Enter"){
                login();
            }
        }
    </script>

    <script>
        function login() {
            if (mobile.value != "" && password.value != "") {
                $.ajax({
                    url: "functions.php",
                    type: "POST",
                    data: {
                        "RESULT_TYPE": "LOGIN",
                        "USERNAME": mobile.value,
                        "PASSWORD": password.value
                    },
                    success: function(res) {
                        var jobj = JSON.parse(res)
                        console.log(jobj);
                        if (jobj.result == 1) {
                            toastr.success("Login Success")
                            setTimeout(() => {
                                window.location.href = 'index.php';

                            }, 500);

                        } else {
                            toastr.error(jobj.message);

                        }
                    }
                });
            } else {
                toastr.info("Enter UserName and Password...!")
            }

        }
    </script>
</body>

</html>
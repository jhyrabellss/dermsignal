<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>

    .sales-detail-cont{
      margin-top: 20px;
      display: grid;
      grid-template-columns: 50% 48.5%;
      gap: 20px;
    }

    .transactions-head{
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .transactions-head input{
      width: 250px;
      padding: 5px;
      outline: none;
      background-color: rgb(247, 244, 244);
      border: none;
    }

    .recent-orders, .top-selling{
      display: flex;
      flex-direction: column;
      padding: 20px;
      font-size: 20px;
      color: gray;
    }
    
    .database-head-transact{
      width: 100%;
      display: grid;
      grid-template-columns: 35% 20% 20% 20%;
      margin-top: 20px;
      font-size: 14px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgb(247, 244, 244);
      align-items: center;
    }

    .database-customer{
      width: 100%;
      display: grid;
      grid-template-columns: 35% 20% 20% 20%;
      margin-top: 20px;
      font-size: 14px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgb(247, 244, 244);
      align-items: center;
    }

    .database-head-product{
      width: 100%;
      display: grid;
      grid-template-columns: 33.3% 33.3% 33.3%;
      margin-top: 20px;
      font-size: 14px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgb(247, 244, 244);
      align-items: center;
      gap: 40px;
    }

    .database-product{
      width: 100%;
      display: grid;
      grid-template-columns: 33.3% 33.3% 33.3%;
      margin-top: 20px;
      font-size: 14px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgb(247, 244, 244);
      align-items: center;
      gap: 40px;
    }



    .database-customer div{
      display: flex;
      justify-content: start;
    }

    .database-customer div:nth-of-type(1){
      font-weight: 500;
      color: black;
    }

    .status-pending{
      padding: 5px;
      background-color: rgb(247, 237, 237);
      border-radius: 5px;
    }

    .status-paid{
      padding: 5px;
      background-color: rgb(209, 245, 214);
      border-radius: 5px;
    }

    .more-contents{
      width: 100%;
      font-size: 12px;
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: black;
    }
    
    .prev-next{
      display: flex;
      align-items: center;
      gap: 10px;
    }

     .prev-next div:nth-of-type(1){
      color: rgb(194, 186, 186);
     }

    .prev-next > .num{
      background-color: var(--background-color);
      border-radius: 3px;
      display: flex;
      width: 30px;
      height: 30px;
      justify-content: center;
      align-items: center;
      border: none;
      color: white;
    } 


    .transaction-image-cont{
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .transaction-image{
      height: 100%;
      width: 40px;
      display: flex;
      align-items: center;
      border: 1px solid var(--background-color);
      justify-content: center;
    }

    .transaction-image img{
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    
  </style>
</head>

<body>

  <nav>
    <div class="left-side-navbar">
      <div class="nav-logo">
          <img src="/images/logo-removebg-preview.png" alt="">
      </div>

    </div>
    <div class="profile-container">
      <div class="user-profile">
        <div>A</div>
      </div>
      <div class="user-name"> Admin </div>
    </div>
  </nav>

  <div class="left-navbar">
    <div class="left-combined">
      <ul class="main-components-leftnav">
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M13.329 3.516c.058.052.114.107.166.166l6 6.75A2 2 0 0120 11.76V19a2 2 0 01-2 2h-3.998H10 6a2 2 0 01-2-2v-7.24a2 2 0 01.505-1.328l6-6.75a2 2 0 012.824-.166zM11 19h2v-4h-2v4zm4 0v-5a1 1 0 00-1-1h-4a1 1 0 00-1 1v5H6v-7.24l6-6.75 6 6.75V19h-3z" clip-rule="evenodd" fill="currentColor"></path></svg>
            </div> 
            <div>Dashboard</div>
        </li>
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M6 15V17H4V15H6ZM19 15C19.5523 15 20 15.4477 20 16C20 16.5523 19.5523 17 19 17H9C8.44772 17 8 16.5523 8 16C8 15.4477 8.44772 15 9 15H19ZM6 11V13H4V11H6ZM19 11C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H9C8.44772 13 8 12.5523 8 12C8 11.4477 8.44772 11 9 11H19ZM6 7V9H4V7H6ZM19 7C19.5523 7 20 7.44772 20 8C20 8.55228 19.5523 9 19 9H9C8.44772 9 8 8.55228 8 8C8 7.44772 8.44772 7 9 7H19Z" fill="currentColor"></path></svg>
            </div> 
            <div>Orders</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 2a8 8 0 100 16 8 8 0 000-16zm4 6a4 4 0 00-8 0h2l.005-.15A2 2 0 1112 12a1 1 0 00-1 1v1a1 1 0 102 0v-.126c1.725-.444 3-2.01 3-3.874zm-3 8v-2h-2v2h2z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Products</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M9.5 2L12 5h8a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2h5.5zm1.563 5l-2.5-3H4v15h16V7h-8.937z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Categories</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M17 11a5.994 5.994 0 015 2.682V17h-8l-.001 1.952.022 1.048H2v-1a6 6 0 019.666-4.748A5.996 5.996 0 0117 11zm-9 4a4.002 4.002 0 00-3.769 2.657l-.062.188-.043.155h7.747l-.037-.137a4.005 4.005 0 00-3.43-2.843l-.206-.015L8 15zm9-2a3.997 3.997 0 00-3.34 1.797l-.125.203h6.929l-.093-.155a4 4 0 00-3.17-1.84L17 13zM8 4a4 4 0 110 8 4 4 0 010-8zm9 0a3 3 0 110 6 3 3 0 010-6zM8 6a2 2 0 100 4 2 2 0 000-4zm9 0h-1v2h2V7 6h-1z" clip-rule="evenodd"></path> </svg>
            </div> 
            <div>Customers</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M18.786 19c.67 0 1.214.448 1.214 1s-.544 1-1.214 1H4.214C3.544 21 3 20.552 3 20s.544-1 1.214-1h14.572zM18 3a2 2 0 012 2v12H3v-4a2 2 0 012-2h3V9a2 2 0 012-2h3V5a2 2 0 012-2h3zM8 13H5v2h3v-2zm5-4h-3v6h3V9zm5-4h-3v10h3V5z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Reports</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12.393 3.08c.233.1.42.283.52.513l2.042 4.684 5.143.471c.547.05.948.528.898 1.068a.977.977 0 01-.334.646l-3.88 3.366 1.136 4.975a.98.98 0 01-.751 1.173 1.004 1.004 0 01-.726-.114L12 17.26l-4.44 2.603a1 1 0 01-1.363-.342.97.97 0 01-.115-.717l1.136-4.975-3.88-3.366a.973.973 0 01-.09-1.384.998.998 0 01.654-.33l5.143-.47 2.042-4.685a.999.999 0 011.306-.513zm1.204 7.044L12 6.462l-1.597 3.662-4.021.367 3.034 2.632-.888 3.888L12 14.976l3.47 2.035-.886-3.888 3.033-2.632-4.02-.367z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Coupons</div>
        </li>
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M19 3a2 2 0 012 2v12a2 2 0 01-2 2H9l-6 3V5a2 2 0 012-2h14zm0 2H5v13.468L8.446 17H19V5zm-8 7v2H7v-2h4zm6-4v2H7V8h10z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Inbox</div>
        </li>
      </ul>
      
      <h5>Authentication</h5>

      <ul class="authentication-leftnav">
          <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="-1 0 24 24" style="vertical-align: middle; fill: none; overflow: hidden;"><path d="M20 18L17 18M17 18L14 18M17 18V15M17 18V21M11 21H4C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </div> 
            <div>Sign up</div>
        </li>
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="1 -0.5 25 25" style="fill: none;"><path d="M15.014 8.46835C14.7204 8.17619 14.2455 8.17737 13.9533 8.47099C13.6612 8.76462 13.6624 9.23949 13.956 9.53165L15.014 8.46835ZM16.971 12.5317C17.2646 12.8238 17.7395 12.8226 18.0317 12.529C18.3238 12.2354 18.3226 11.7605 18.029 11.4683L16.971 12.5317ZM18.029 12.5317C18.3226 12.2395 18.3238 11.7646 18.0317 11.471C17.7395 11.1774 17.2646 11.1762 16.971 11.4683L18.029 12.5317ZM13.956 14.4683C13.6624 14.7605 13.6612 15.2354 13.9533 15.529C14.2455 15.8226 14.7204 15.8238 15.014 15.5317L13.956 14.4683ZM17.5 12.75C17.9142 12.75 18.25 12.4142 18.25 12C18.25 11.5858 17.9142 11.25 17.5 11.25V12.75ZM3.5 11.25C3.08579 11.25 2.75 11.5858 2.75 12C2.75 12.4142 3.08579 12.75 3.5 12.75V11.25ZM13.956 9.53165L16.971 12.5317L18.029 11.4683L15.014 8.46835L13.956 9.53165ZM16.971 11.4683L13.956 14.4683L15.014 15.5317L18.029 12.5317L16.971 11.4683ZM17.5 11.25H3.5V12.75H17.5V11.25Z" fill="currentColor"></path><path d="M9.5 15C9.5 17.2091 11.2909 19 13.5 19H17.5C19.7091 19 21.5 17.2091 21.5 15V9C21.5 6.79086 19.7091 5 17.5 5H13.5C11.2909 5 9.5 6.79086 9.5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15.014 8.46835C14.7204 8.17619 14.2455 8.17737 13.9533 8.47099C13.6612 8.76462 13.6624 9.23949 13.956 9.53165L15.014 8.46835ZM16.971 12.5317C17.2646 12.8238 17.7395 12.8226 18.0317 12.529C18.3238 12.2354 18.3226 11.7605 18.029 11.4683L16.971 12.5317ZM18.029 12.5317C18.3226 12.2395 18.3238 11.7646 18.0317 11.471C17.7395 11.1774 17.2646 11.1762 16.971 11.4683L18.029 12.5317ZM13.956 14.4683C13.6624 14.7605 13.6612 15.2354 13.9533 15.529C14.2455 15.8226 14.7204 15.8238 15.014 15.5317L13.956 14.4683ZM17.5 12.75C17.9142 12.75 18.25 12.4142 18.25 12C18.25 11.5858 17.9142 11.25 17.5 11.25V12.75ZM3.5 11.25C3.08579 11.25 2.75 11.5858 2.75 12C2.75 12.4142 3.08579 12.75 3.5 12.75V11.25ZM13.956 9.53165L16.971 12.5317L18.029 11.4683L15.014 8.46835L13.956 9.53165ZM16.971 11.4683L13.956 14.4683L15.014 15.5317L18.029 12.5317L16.971 11.4683ZM17.5 11.25H3.5V12.75H17.5V11.25Z" fill="currentColor"></path><path d="M9.5 15C9.5 17.2091 11.2909 19 13.5 19H17.5C19.7091 19 21.5 17.2091 21.5 15V9C21.5 6.79086 19.7091 5 17.5 5H13.5C11.2909 5 9.5 6.79086 9.5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </div> 
            <div>Sign in</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24" style="vertical-align: middle; fill: none; overflow: hidden;"><path d="M21 8.5V6C21 4.89543 20.1046 4 19 4H5C3.89543 4 3 4.89543 3 6V11C3 12.1046 3.89543 13 5 13H10.875M19 14V12C19 10.8954 18.1046 10 17 10C15.8954 10 15 10.8954 15 12V14M14 20H20C20.5523 20 21 19.5523 21 19V15C21 14.4477 20.5523 14 20 14H14C13.4477 14 13 14.4477 13 15V19C13 19.5523 13.4477 20 14 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="7.5" cy="8.5" r="1.5" fill="currentColor"></circle><circle cx="12" cy="8.5" r="1.5" fill="currentColor"></circle></svg>
            </div> 
            <div>Forgot Password</div>
        </li>

        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 1024 1024" style="vertical-align: middle; fill: none; overflow: hidden; padding: 1px;"><path d="M332.8 814.08c-51.2 0-92.16-40.96-92.16-87.04v-179.2c0-51.2 40.96-92.16 92.16-92.16h40.96v-102.4c0-76.8 61.44-138.24 138.24-138.24 76.8 0 138.24 61.44 138.24 138.24v102.4h35.84c51.2 0 92.16 40.96 92.16 92.16v179.2c0 51.2-40.96 87.04-92.16 87.04H332.8z m0-302.08c-20.48 0-35.84 15.36-35.84 35.84v179.2c0 20.48 15.36 35.84 35.84 35.84h348.16c20.48 0 35.84-15.36 35.84-35.84v-179.2c0-20.48-15.36-35.84-35.84-35.84H332.8z m256-56.32v-102.4c0-46.08-35.84-81.92-81.92-81.92-40.96 0-76.8 35.84-76.8 81.92v102.4h158.72z" fill="currentColor"></path><path d="M512 1024C235.52 1024 10.24 798.72 10.24 522.24S235.52 20.48 512 20.48c117.76 0 225.28 40.96 317.44 112.64L808.96 35.84c0-5.12 0-15.36 5.12-20.48 5.12-10.24 10.24-15.36 15.36-15.36h5.12c10.24 0 25.6 10.24 25.6 20.48l35.84 184.32v5.12c0 15.36-10.24 25.6-20.48 25.6l-184.32 35.84h-5.12c-10.24 0-25.6-10.24-25.6-20.48 0-5.12 0-15.36 5.12-20.48 5.12-5.12 10.24-10.24 15.36-10.24l133.12-25.6c-81.92-76.8-189.44-117.76-302.08-117.76-245.76 0-445.44 199.68-445.44 445.44s199.68 445.44 445.44 445.44c245.76 0 445.44-199.68 445.44-445.44 0-30.72 0-56.32-5.12-81.92 0-10.24 0-15.36 5.12-20.48 0-10.24 5.12-15.36 15.36-15.36h5.12c15.36 0 25.6 10.24 30.72 25.6 5.12 30.72 10.24 61.44 10.24 92.16-5.12 276.48-230.4 501.76-506.88 501.76z" fill="currentColor"></path></svg>
            </div> 
            <div>Reset Password</div>
        </li> 
      </ul>

      <h5>Settings</h5>

      <ul class="settings-leftnav">
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 12a8 8 0 017.996 7.75L20 20v1H4v-1a8 8 0 018-8zm0 2a6.002 6.002 0 00-5.851 4.667l-.048.23-.017.103h11.831l-.016-.102a6.003 6.003 0 00-5.425-4.88l-.25-.014L12 14zm0-11a4 4 0 110 8 4 4 0 010-8zm0 2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Personal Settings</div>
        </li> 
        <li>
            <div><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-10dohqv" focusable="false" aria-hidden="true" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M13.5 2L16 5l4 .5 2 3-2 3.5 2 3.5-2 3-4 .5-2.5 3h-3L8 19l-4-.5-2-3L4 12 2 8.5l2-3L8 5l2.5-3h3zm-.938 1.999h-1.125L9.031 6.887l-3.875.483-.806 1.211L6.304 12 4.35 15.418l.806 1.211 3.875.484L11.436 20h1.127l2.406-2.886 3.874-.484.806-1.211L17.696 12l1.953-3.419-.806-1.211-3.874-.483-2.407-2.888zM12 8a4 4 0 110 8 4 4 0 010-8zm0 2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"></path></svg>
            </div> 
            <div>Global Settings</div>
        </li> 
      </ul>

    </div>
  </div>

  <div class="main-contents-cont">
    <div class="product-details-main-cont">
        <div class="saved-products">
          <div class="svg-cont" id="saved">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mage MuiBox-root css-8u0ysq" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M21.19 12.683c-2.5 5.41-8.62 8.2-8.88 8.32a.85.85 0 0 1-.62 0c-.25-.12-6.38-2.91-8.88-8.32c-1.55-3.37-.69-7 1-8.56a4.93 4.93 0 0 1 4.36-1.05a6.16 6.16 0 0 1 3.78 2.62a6.15 6.15 0 0 1 3.79-2.62a4.93 4.93 0 0 1 4.36 1.05c1.78 1.56 2.65 5.19 1.09 8.56"></path></svg>
          </div>
          <div>
            <div>
              <h4>178+</div>
              <div>Save Products</div>
          </div>
        </div>
  
        <div class="stock-products">
          <div class="svg-cont" id="stock">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar MuiBox-root css-1n4e2b2" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M15 1.25a.75.75 0 0 1 .75.75v1A1.75 1.75 0 0 1 14 4.75h-1a.25.25 0 0 0-.25.25v1H14c3.771 0 5.657 0 6.828 1.172S22 10.229 22 14s0 5.657-1.172 6.828S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172S2 17.771 2 14s0-5.657 1.172-6.828S6.229 6 10 6h1.25V5c0-.966.784-1.75 1.75-1.75h1a.25.25 0 0 0 .25-.25V2a.75.75 0 0 1 .75-.75M8.75 12a.75.75 0 0 0-1.5 0v1.05a.2.2 0 0 1-.2.2H6a.75.75 0 0 0 0 1.5h1.05c.11 0 .2.09.2.2V16a.75.75 0 0 0 1.5 0v-1.05c0-.11.09-.2.2-.2H10a.75.75 0 0 0 0-1.5H8.95a.2.2 0 0 1-.2-.2zM15 13.5a1 1 0 1 0 0-2a1 1 0 0 0 0 2m3 2a1 1 0 1 1-2 0a1 1 0 0 1 2 0" clip-rule="evenodd"></path></svg>
          </div>
          <div>
            <div>
              <h4>20+</div>
              <div>Stock Products</div>
          </div>
        </div>
        <div class="sales-products" >
          <div class="svg-cont" id="sales">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar MuiBox-root css-ey2c5d" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.25 7.013V6a3.75 3.75 0 1 1 7.5 0v1.013c1.297.037 2.087.17 2.692.667c.83.68 1.06 1.834 1.523 4.143l.6 3c.664 3.32.996 4.98.096 6.079S18.067 22 14.68 22H9.32c-3.386 0-5.08 0-5.98-1.098s-.568-2.758.096-6.079l.6-3c.462-2.309.693-3.463 1.522-4.143c.606-.496 1.396-.63 2.693-.667M9.75 6a2.25 2.25 0 0 1 4.5 0v1h-4.5zM15 11a1 1 0 1 0 0-2a1 1 0 0 0 0 2m-5-1a1 1 0 1 1-2 0a1 1 0 0 1 2 0" clip-rule="evenodd"></path></svg>
          </div>
          <div>
            <div>
              <h4>190+</div>
              <div>Sales Products</div>
          </div>
        </div>
    </div>

    <div class="main-details-cont">
      <div class="chart-div">
        <div id="chart" style="width: 600px;"></div>
      </div>
      <div class="doughnut-div">
        <canvas id="myDoughnutChart"></canvas>
      </div>
    </div>
    
    <div class="sales-detail-cont">
      <div class="recent-orders">
        <div class="transactions-head">
          <div>Recent Transactions</div>
          <div><input type="text" placeholder="Search user..."></div>
        </div>
        <div class="database-head-transact">
            <div>Name</div>
            <div>Date</div>
            <div>Amount</div>
            <div>Status</div>
        </div>
        <div class="database-customer">
            <div>Jhyra</div>
            <div>11/11/24</div>
            <div>100</div>
            <div><div class="status-pending">Pending</div></div>
        </div>
        <div class="database-customer">
          <div>Jhaymark</div>
          <div>11/11/24</div>
          <div>100</div>
          <div><div class="status-pending">Pending</div></div>
        </div>
        <div class="database-customer">
          <div>Marie</div>
          <div>11/11/24</div>
          <div>100</div>
          <div><div class="status-pending">Pending</div></div>
        </div>
        <div class="database-customer">
          <div>Mae</div>
          <div>11/11/24</div>
          <div>100</div>
          <div><div class="status-paid">Paid</div></div>
        </div>

        <div class="more-contents">
          <div>Showing 1 to 5 of 15 data</div>
          <div class="prev-next">
            <div>Previous</div>
            <div class="num">1</div>
            <div >2</div>
            <div >3</div>
            <div>Next</div>
          </div>
        </div>
      
      </div>

      <div class="top-selling">
        <div class="transactions-head">
          <div>Recent Transactions</div>
          <div><input type="text" placeholder="Search user..."></div>
        </div>
        <div class="database-head-product">
            <div>Name</div>
            <div>Price</div>
            <div>Units Sold</div>
        </div>
        <div class="database-product">
            <div class="transaction-image-cont">
              <div class="transaction-image">
                <img src="../images/oral_medication/crys/bottlefront.webp"alt="">
              </div>
              <div>Crystal Serum Sunscreen</div>
            </div>
            <div>₱100</div>
            <div>15</div>
        </div>
        <div class="database-product">
          <div class="transaction-image-cont">
            <div class="transaction-image">
              <img src="../images/renewal/2.png"alt="">
            </div>
            <div>Skin Renewal Fruit Mix Booster</div>
          </div>
          <div>₱100</div>
          <div>10</div>
        </div>
        <div class="database-product">
          <div class="transaction-image-cont">
            <div class="transaction-image">
              <img src="../images/refining/4.png"alt="">
            </div>
            <div>Acne Refining Gel</div>
          </div>
          <div>₱100</div>
          <div>5</div>
        </div>
        <div class="database-product">
          <div class="transaction-image-cont">
            <div class="transaction-image">
              <img src="../images/oral_medication/crys/bottlefront.webp"alt="">
            </div>
            <div>Crystal Silicone Sunscreen</div>
          </div>
          <div>₱100</div>
          <div>5</div>
        </div>

        <div class="more-contents">
          <div>Showing 1 to 5 of 15 data</div>
          <div class="prev-next">
            <div>Previous</div>
            <div class="num">1</div>
            <div >2</div>
            <div>Next</div>
          </div>
        </div>
      </div>
    </div>
    

  </div>



</body>
<script>
 
    // ApexCharts: Line chart setup
    var lineData = [];
    var lastDate = new Date().getTime();
    const XAXISRANGE = 777600000;  // Example for 9-day range in ms

    // Create initial data for the ApexCharts line chart
    for (let i = 0; i < 10; i++) {
      lineData.push({ x: lastDate - XAXISRANGE + i * 86400000, y: Math.floor(Math.random() * 90) + 10 });
    }

    function getNewSeries(baseval, range) {
      lastDate += 86400000; // Move to next day
      lineData.push({ x: lastDate, y: Math.floor(Math.random() * (range.max - range.min)) + range.min });
      if (lineData.length > 50) lineData.shift();  // Maintain fixed data length
    }

    var lineOptions = {
      series: [{
        data: lineData.slice()
      }],
      chart: {
        id: 'realtime',
        height: 350,
        type: 'line',
        animations: {
          enabled: true,
          easing: 'linear',
          dynamicAnimation: {
            speed: 1000
          }
        },
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      colors: ['rgb(39,153,137)'],
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth' },
      title: {
        text: '1 Year Sale',
        align: 'left',
        style: {
          fontFamily: 'Poppins',
          fontSize: '20px',
          fontWeight: 'bold',
          color: 'rgb(39,153,137)'
        }
      },
      markers: { size: 0 },
      xaxis: { type: 'datetime', range: XAXISRANGE },
      yaxis: { max: 100 },
      legend: { show: false },
      tooltip: {
        enabled: true,
        theme: 'light',
        style: {
          background: 'rgb(39,153,137)',
          color: 'rgb(39,153,137)',
          fontSize: '12px',
          fontFamily: 'Poppins',
        },
        x: {
          show: true,
          formatter: function(val) {
            return 'Date: ' + new Date(val).toLocaleDateString();
          }
        },
        y: {
          formatter: function(val) {
            return 'Sales: ' + val;
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), lineOptions);
    chart.render();

    var intervalRuns = 0;
    var interval = window.setInterval(function () {
      intervalRuns++;
      getNewSeries(lastDate, { min: 10, max: 90 });

      chart.updateSeries([{
        data: lineData
      }]);

      if (intervalRuns === 2 && window.isATest === true) {
        clearInterval(interval);
      }
    }, 1000);

    const doughnutData = {
  labels: ['Sale', 'Distribute', 'Return'],
  datasets: [{
    label: 'My First Dataset',
    data: [100, 30, 20],
    backgroundColor: [
      'rgb(255, 99, 132)', // Color for Sale
      'rgb(54, 162, 235)', // Color for Distribute
      'rgb(255, 205, 86)'  // Color for Return
    ],
    borderWidth: 1,         // Add border width to create the effect
    borderColor: 'white',    // Set border color to white
    hoverOffset: 4
  }]
};

const doughnutConfig = {
  type: 'doughnut',  // Doughnut chart type
  data: doughnutData,  // Data for the doughnut chart
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          font: {
            family: 'Poppins',   // Change the font family
            weight: 'normal',    // Optional: make the text bold
            size: '20'           // Change the font size
          }
        }
      },
      tooltip: {
        enabled: true,
        backgroundColor: 'rgba(39, 153, 137, 0.7)',  // Custom tooltip background color (semi-transparent black)
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.label + ': ' + tooltipItem.raw + ' units'; // Custom tooltip label
          }
        },
        bodyFont: {
          family: 'Poppins',   // Font family for tooltip body text
          size: 14,            // Font size for tooltip body text
        },
        titleFont: {
          family: 'Poppins',   // Font family for tooltip title
          size: 16,            // Font size for tooltip title
        },
      }
    },
    // Doughnut chart options for rounded corners
    elements: {
      arc: {
        borderRadius:10, // Set the border radius to make the edges rounded
      }
    }
  }
};

// Get the context of the canvas element for Chart.js
const ctx = document.getElementById('myDoughnutChart').getContext('2d');

// Create a new Chart instance for the doughnut chart
const myDoughnutChart = new Chart(ctx, doughnutConfig);



   

</script>
<script>
const data = [
  {
    name: "John Doe",
    date: "04.01.2024",
    amount: 100,
    status: "pending"
  },
  {
    name: "Jane Smith",
    date: "05.02.2024",
    amount: 150,
    status: "pending"
  },
  {
    name: "Bob Williams",
    date: "04.03.2024",
    amount: 120,
    status: "pending"
  },
  {
    name: "Alice Johnson",
    date: "14.03.2024",
    amount: 200,
    status: "paid"
  },
  {
    name: "James Thompson",
    date: "01.04.2024",
    amount: 160,
    status: "pending"
  }
];



</script>
</html>
/**
 * Holds a single JSON object containing the current book to be added to the shopping cart. 
 * This will be used to display the book on the modal after the book has been successfully added to the shopping cart on the server.
 * 
 * @type object
 */
var book = {};

/**
 * Holds a collection of objects representing all the books displayed on the page.
 * 
 * @type object
 */
var books = {};

/**
 *  Holds a JSON object containing a collection of objects representing the books in the shopping cart. 
 *  
 * @type object
 */
var cartJSON = null;

/**
 *  Stores the an array of all the categories of books.
 *  
 * @type array
 */
var catArray;


/**
 * Stores an array of arrays of the fields in each category. 
 * Take a look at storage/app/books.json.
 * 
 * @type array
 */
var categories; 

/**
 * 
 * @type DOMString|String.host
 */
var host = window.location.host;

/**
 * 
 * @type String.href|DOMString
 */
var href = window.location.href;

/**
 * 
 * @type DOMString|String.pathname
 */
var path = window.location.pathname;

/**
 * 
 * @type Number
 */
var randN;

/**
 * 
 * @type String
 */
var currency = 'R';

/**
 * Setting up the AJAX setup.
 */
$.ajaxSetup({
    headers:{
        "X-CSRF-TOKEN":$("meta[name='token']").attr('content')
    },
    error:function(xhr, status, error){
        /*handle latter;*/
        //xhr.status
        //xhr.statusText
    }
});


/**
 * Setting up the functions to run when the pages finish loading.
 * 
 */
$(document).ready(function(){
    /*
     * Deactivate all links having "#" as the value of thier href attribute. 
     */
    $('[href="#"]').on('click', function(e){
        e.preventDefault();
    });
    
    /*
     * Resize the navigation column when the page is loaded.
     */    
    resizeNavCol();
    
    /*
     * resizeNavCol() is called whenever the window is resized to resize the navigation column according to the slider <img> height
     */
    $(window).resize(function(){
        resizeNavCol();
    });
	
    /*
     * Get the books.json file containing the categories and subcategories of books in the DB
     */
    getBookCategories();

    /*
     *  the cart anytime a new page is loaded or the current page is refreshed
     */
    updateCart();

    /*
     * Initialized the popover in which the content of the shopping cart is displayed.
     */
    $('[data-toggle="popover"]').popover({
        placement:'bottom'
    });
    
    /*
     * Preloads the popover initialized above with a current list of books in the shopping cart object cartJSON by calling updateCart()
     */
    $('[data-toggle="popover"]').on('shown.bs.popover', function(){
        updateCart();
    });

    /*
     * Provides auto suggestion/auto completion functionality. 
     */
    $("input[type='search']").on('keyup', function(e){
        runSuggest(e);
    });

    /*
     * Form validation for search bar on small screen
     */
    $('#search_icon').on('click', function(){
        validateMobile();
    });
    
    /*
     * From validation for search bar on large screen
     */
    $('#search_btn').on('click', function(e){
        validateDesktop(e);
    });

    /*
     * Test for if user is on 'failed transaction' page and display an appropriate message.
     */
    failedTransaction();

    /*
     * Fix the pagination links for search result pages.
     */
    fixPagination();	
});


/**
* resizeNavCol() resizes the overall height of the vertical navigation <nav> <ul>
* It does this by resizing the height of <li> and its font size.
* The new size is obtained by calculation based on the height of the slider <img>
* The <li> height is equals the slider <img> height divided by the number of <li>.
* 
* @returns {void}
*/
function resizeNavCol(){
    var navCol, slider, sliderH, list,  noOfList, navH, listFontSize;
    noOfList = 9;  
    navCol = $('#nav_col');
    slider = $('#slider');
    list = navCol.children();
    sliderH = slider.height();
    if (sliderH) {
        navCol.height(sliderH);
        navH  = navCol.height();
        list.height(parseInt(navH/noOfList)-1); 
        listFontSize  = navH/24; 
        list.css('font-size', listFontSize+'px');
    } else {
        setTimeout(resizeNavCol, 3000);
    }
}

 /**
 * An AJAX call to get JSONfile which holds the categories and subcategory of the books stored in the database.
 * The object retrieved is used in building the rows of book catrgories using build() and to display them on the page. 
 * 
 * @returns {void}
*/   
function getBookCategories(){
    $.getJSON('/getJSONfile', function(data, status){
        catArray = data['catArray'];
        categories = data['categories'];
        homePages = ['http://ojlinks.tochukwu.xyz', 'http://ojlinks.tochukwu.xyz/', 'http://ojlinks.test:8080/', 'http://ojlinks.test:8080'];
        //Display just 3 rows of books ONLY for the index page. The user can request more later. 
        if(homePages.includes(href)){
            randN = randomArrayIndex(catArray); //randN becomes a randon array index
            noOfRecursion = 3;
            build(catArray[randN], noOfRecursion);
        }
    });
}

/**
 * Updates the shopping cart anytime there is a page refresh or a new page is loaded.
 * 
 * @returns {void}
 */

function updateCart(){
    var n, price, s;
    if (cartJSON==null) {
        $.get('/cart/get', function(data, status){
            cartJSON = data;
            assembleCart(cartJSON);

            n = getNoOfBooks();
            price = getTotalPrice();
            s = (n > 1)?  's' :  ' '; 
            $('#cart-book-no').text(n+' Book'+s);
            $('#cart-price').text(currency+price);
            $('#cart-badge').text(n);
        });
    } else if (getObjSize(cartJSON) == 0) {
        assembleCart(0);
    } else {
        assembleCart(cartJSON);
    }
    n = getNoOfBooks();
    price = getTotalPrice();
    s = (n > 1)? 's' :  ' '; 
    $('#cart-book-no').text(n+' Book'+s);
    $('#cart-price').text(currency+price); 
    $('#cart-badge').text(n);

}


/**
 * Provides auto suggest functionality for the search input field.
 * Sends a request to the sever after the user's third input character and returns a list of matched string as auto suggestion list.
 *
 * @param {event} e
 * @returns {void}
 */
function runSuggest(e){
    var elem, phrase, options, titleList, strLen, tt='';
    elem = $(e.currentTarget);
    phrase = elem.val();
    strLen = phrase.length
    /*Run database search for keyword after every 3 letter is entered */
    if (strLen >= 3 && strLen%3 == 0) {
        $.get('/db/suggest?word='+phrase, function(data, status){
            titleList = data;
            $('#search-db').empty();
            options='';
            for (var item in titleList) {
                options += "<option value='"+titleList[item]['title']+"'>";
            }
            $('#search-db').append(options);
        });
    }	
}

/**
 * Performs search form validation for small screen.
 * 
 * @returns {void}
 */
function validateMobile(){
    var searchTitle = $('#search_icon_input').val();
    var alertDiv = '<div class="alert alert-danger">Please enter a book title to search!</div>';
    if ( searchTitle == '' || searchTitle == null) {					
        $('.book-cat-header:first-child').before(alertDiv);
        $('.alert-danger').fadeOut(5000);
    } else {
        $('#search_form').submit();
    }    
}

/**
 * Performs search form validation for medium and large screens.
 * 
 * @param {event} e
 * @returns {void}
 */
function validateDesktop(e){
    var searchVal = $('#search_btn_input').val();
    var alertDiv = '<div class="alert alert-danger">Please enter a book title to search!</div>';
    if(searchVal == '' || searchVal == null){
        e.preventDefault();
        $('.book-cat-header:first-child').before(alertDiv);
        $('.alert-danger').fadeOut(5000);						
    }   
}

/**
 * Checks if the user if on the failed transaction page and displays a modal if so.
 * 
 * @returns {void}
 */
function failedTransaction(){
    if (href.match(/cart\/checkout\?status=failed/)) {
        var para =  "<p class=\'added\'>Your transaction was unsuccessful</p>"+
                           "<p class=\'title\'>Please try again.</p>" ;                        
        var footer = "<p class=\'foot\'><button class=\'btn btn-sm\' data-dismiss=\'modal\'>Ok</button></p>";
        $("#modal").on("show.bs.modal", function(){
            $("#modal .modal-title").text("Transaction Unsuccessful");
            $("#modal #left-body").html();
            $("#modal #right-body").html(para);
            $("#modal #right-body").append();
            $("#modal .modal-footer").html(footer);
        });
        $("#modal").modal(); 
    }
   
}
 
/* *
 * To take care of the Laravel links() function problem in the search page. This is intended to be a temporal solution.
 * Laravel adds some urlencoded string '%3D' to the search query. I remove them with this function.
 * 
 * @returns {void}
 */
function  fixPagination(){
    if (href.match(/search/)) {		
        var aLink = $('.pagination a').attr('href');
        if (aLink.match(/%3D/)) {			
            var newLink = aLink.replace('%3D','');
        }
        $('.pagination a').attr('href',newLink);
    }     
}
 
 
/**
* build() assembles all the elements that makes up a rows of book category. It does this recursively.
* It calls itself again and again to build another row of book category, default is 3 iterations. The user can make more request subsequently.
* Each time a row is built the relevant category is removed from the 'categories' array until all categories have been built and categories array becomes empty.
* 
* @param {string} field A given category.
* @param {int} noOfrecursion The number of recursion.
*/

var count = 0; //counter for number of recursion of the build() function
var template='';
var id, title, price, author, img, data, subjectLink,  subjectField, fieldLink, noOfRecursion, loadingFan;
    function build(field, noOfRecursion){
    if (catArray.length==0) {
        return false;
    }
    noOfRecursion = (noOfRecursion==undefined)? 3 : noOfRecursion;
    loadingFan = '<p class="text-center loading-fan" ><img src="/img/loading.gif" alt="Loading page content..." title="Loading page content..."/></p>';
    $('#book_items .row').append(loadingFan);

    subjectField = categories[field]; 
    fieldLink =field.replace(/-/g, " ");
    template += '<div class="col-sm-12 book-cat-header">'+
                            '<h4><a href="/'+field+'">'+fieldLink+'</a>'+
                                '<span class="hidden-xs"> | &nbsp; </span>'+
                                '<span><a href="#" class="subjects transition" aria-hidden="true" onclick="showSubjects(this); return false"> &raquo;</a></span>'+
                           '</h4>'+
                           '<ul class="list-inline list-unstyled">';

    for (var subject in subjectField) {
        subjectLink = subjectField[subject];
        subj = subjectLink.replace(/-/g, " ");
        template += '<li><a href="/'+field+'/'+subjectLink+'">  '+ subj+'</a></li>';
    }
    template += '</ul>'+
                          '</div>'+
                       '<div class="col-md-12 col-sm-12">';
		
    /*AJAX request for the book records. */
    $.get('/getbooks/'+field, function(data, status){   
        data  = JSON.parse(data);  
        var j = 1, addCl='';
        //Looping the JSON object returned from the server
        for (var record in data) {
            addCl = (j>=5)? 'hidden-sm hidden-xs' : ''
            id = data[record].id;
            title = data[record].title;
            author = data[record].author;
            price  =  formatNumber(data[record].price);
            img = data[record].img;
            
            book = {"id":id, "title":title, "author":author, "price":price, "img":img}; 
            books[id] = book; //Updates the books object by adding new object to the collection of book objects
                    
            template+= '<div id="'+id+'" class="col-md-2 col-sm-3 '+addCl+'">'+
                                   '<img src="/storage/book_img/'+(img)+'" title="'+title+'" alt="'+title+'" data-toggle="tooltip" onmouseover="showToolTip()" onerror="loadDefaultImage(this)"/>'+
                                   '<p class="title">'+title+' </p>'+
                                   '<p class="by">By </p>'+
                                   '<p class="author"  title="'+author+'" data-toggle="tooltip" onmouseover="showToolTip()"">'+author+'</p>'+
                                   '<p class="price">'+currency+price+' </p>'+
                                   '<p class="details"><a href="/book/'+id+'">View Details</a></p>'+
                                  '<button class="btn btn-sm" data-bookid="'+id+'" onclick ="addToCart(this)">Add to Cart</button>'+
                               '</div>';
                            j++;
        }
        template +='</div>';

        $('p.text-center.loading-fan').remove();
        $('#book_items .row').append(template);

        template = ''; 
        count++;

        catArray.splice(randN, 1); //Removes the element from the catArray Array.
        if (catArray.length<1) {
            $('#load_more').hide(); //Hide the loadmore button(link) when the catArray has become empty
        } else {
            $('#load_more').show(); // Redisplay the link after loading new content.
        }

        if (noOfRecursion === count) {
            return false;
        }

        randN = randomArrayIndex(catArray) ; //randN becomes a randon array index
        build(catArray[randN], noOfRecursion);	
    });

}

/**
* Loads more book on the index page via a AJAX request.
* More books are loaded for display when the user's clicks the 'more books' link.
* 
* @returns {void}
*/
function loadMoreBooks(){
    $('#load_more').hide(); //Hide the link to prevent multiple clicking. The link will be redisplayed after build() is executed 
    if (catArray.length == 0) {
        return false;
    }
    randN = randomArrayIndex(catArray);
    noOfRecursion = 2;
    count = 0; //Resetting the build() function recursion counter.
    build(catArray[randN], noOfRecursion);
}





/**
* showSubjects() displays the subjects under a category when the arrow(>>) is clicked.
* Unfortunately $(document).ready() seems to be unable to listen for events on new elements appended after the page has loaded.
* For this reason, this function is outside $(document).ready() and a traditional onclick  attribute is defined in the generated elements.
* 
* @returns {void}
*/
function showSubjects(elem){
    var arrowElem = $(elem);
    var spanElem = arrowElem.parent();
    var h4Elem = spanElem.parent();
    var ulElem = h4Elem.next();
    ulElem.slideToggle('fast');
    arrowElem.toggleClass('rotate');
}

/**
 * addToCart() sends AJAX request to the server to add user's book choice to the shopping cart.
 * It also triggers a modal that informs the user what the chosen book has been added to the shopping cart
 * 
 * @param object buttonElem
 * @returns {void}
 */
function addToCart(buttonElem){
    /* For other pages aside the index page, the books object will be empty initially after the page is loaded.
     * To solve this problem, @var sentBooks will be set to a JSON object containing all the books that was loaded when the page was requested.
     * @var sentBooks can be seen in 'resouces/view/subject.blade.php' and 'resouces/view/field.blade.php'. 
     * Here we  transfer all the loaded books from @var sentBooks into the 'books' object for normal operation.
     */
    if (getObjSize(books) == 0) {
        var id, title, author, price, img;
    /*
     * The book id keys in the sentBooks JSON object collection is different by 1 from the actual id which is recording in each book object.
     * eg: {7:{id:8, title:'book title 8'}, 8:{id:9, title:'book title 9'}}
     * This loop corrects that so that the example above becomes {8:{id:8, title:'book title 8'}, 9:{id:9, title:'book title 9'}}.
     * It does this by replace the key of each object by its actual id value.
     */
        for (var item in sentBooks) {
            id = sentBooks[item]['id'];
            title = sentBooks[item]['title'];
            author = sentBooks[item]['author'];            
            price =  formatNumber(sentBooks[item]['price']);
            img = sentBooks[item]['img'];

            book = {"id":id, "title":title, "author":author, "price":price, "img":img};
            books[id] = book;
        }
        /*The problem above has been corrected for the 'sentBooks' variable you may have to remove this for statement later*/
    }

    /*Adding the chosen book to the shopping cart*/
    var bookid = $(buttonElem).attr('data-bookid');
    $(buttonElem).attr('disabled','disabled');	
    $.get('/cart/book/'+bookid, function(data, status){
        cartJSON = data;
        var id = bookid;
        var noOfBooks = getNoOfBooks();
        var image = "<img src='/storage/book_img/"+(books[id]['img'])+"' alt='"+books[id]['title']+"' onerror='loadDefaultImage(this)'/>";
        var para = "<p class='title'>"+books[id]['title']+"</p>" +
                         "<p class='by'> By </p>"+ 
                         "<p class='author'>"+books[id]['author']+"</p>"+
                         "<p class='added'>has been added to your shopping cart. </p>";
        var footer = "<p class='foot'>Number of Books in shopping cart is "+noOfBooks+".</p>";
        $('#modal').on('show.bs.modal', function(){
            $('#modal .modal-title').text("New Book added to shopping Cart.");
            $('#modal #left-body').html(image);
            $('#modal #right-body').html(para);
            $('#modal .modal-footer').html(footer);
        });
        $('#modal').modal();
        $(buttonElem).removeAttr('disabled');
        updateCart();
});
    
  
}

/**
 * Assembles the collections of objects in the cartJSON object.
 * The collection makes up the list of books in the shopping cart
 * 
 * @param object data
 * @returns {void}
 */
function assembleCart(data){
/*find out if we are in the checkout page*/
    if (path.match(/checkout/i)) {
        assembleCheckout();
    }

    if (data==0) {
        $('div.popover').empty();
        $('div.popover').append('<div class="arrow"></div><div class="popover-content"></div>');
        $('.popover-content').append("<p>Your shopping cart is empty!</p>");
    } else {
        var id, img, title, btn, author, copies, plural, str=' ';
        for (var book in data) {
            id = data[book].id;
            img = data[book].img;
            title =  data[book].title;
            author =  data[book].author;
            copies =  data[book].copies;
            price =   formatNumber(data[book].price);
            plural = (copies>1)?  copies+' copies - ' : ' ';

            str += '<div class="cart-divs">'+
                           '<div class="del"><span title="Remove book" data-toggle="tooltip" onmouseover="showToolTip()" onclick="askToRemove('+id+')">&times;</span></div>'+
                           '<div class="col50">'+  				
                               '<img src="/storage/book_img/'+(img)+'" title="'+title+'" alt="'+title+'"/>'+						 
                          '</div>'+ 
                          '<div class="col50">'+
                              '<p class="title">'+title+' </p>'+
                              '<p class="author">'+author+' </p>'+
                             '<p class="copies">'+plural+ currency +price+'</p>'+
                             '</div>'+
                          '</div>';
        }
        btn = '<p><button class="btn btn-xs" onclick="askToEmpty()">Empty Cart</button>'+
                 '<button class="btn btn-xs" onclick="checkOut()">Check out</button></p>';
		
        $('div.popover').empty();
        $('div.popover').append('<div class="arrow"></div><div class="popover-content"></div>');
        $('.popover-content').append(str+btn);
    }	
}

/**
* Assembles the order summary for the items in the shopping cart on the checkout page.
*  The ordered item is stored as a collection in the cartJSON object.
* This collection is updated on every page refresh and also when any 'remove' button is clicked or 'quantity input' field is adjusted.
*
*@returns {void}
 */
function assembleCheckout(){
    var bookID, img, title, price, unit_price, copies, foot, rows =" ";
    var noOfItems = getObjSize(cartJSON); 	
    for (var book in cartJSON) { 
        bookID = cartJSON[book]['id'] ;
        img= cartJSON[book]['img'] ;
        title = cartJSON[book]['title'];
        price =  formatNumber(cartJSON[book]['price']);
        unit_price =  formatNumber(cartJSON[book]['unit_price']);
        copies = cartJSON[book]['copies'];
        rows += "<tr>"+
                          "<td><div><img src='/storage/book_img/"+(img)+"'/></div></td>"+
                          "<td>"+title+"</td>"+
                          "<td>"+currency+unit_price+"</td>"+
                          "<td><input type='text' value='"+copies+"' readonly='readonly' onclick='changeState(this)' onchange='changeQuantity(this)' data-bookID='"+bookID+"'/></td>"+
                          "<td><button class='btn btn-sm' onclick='askToRemove("+bookID+")'>Remove</button></td>"+
                          "<td>"+currency+price+"</td>"+
                       "</tr>";
    }
    foot = "<tr>"+
                  "<td colspan='5'><h4>Grand Total</h4></td>"+
                  "<td><h4>"+currency+''+getTotalPrice()+"</h4></td>"+
              "</tr>";
    $('tbody').html(rows);
    $('tfoot').html(foot);
	
    if (noOfItems == 0) {
        foot = "<tr>"+
                      "<td colspan='6'><h4>Your shopping cart is empty</h4></td>"+           
                  "</tr>";
        $('tfoot').html(foot );
        $('#confirm_order_btn').hide();
        return false;
    }
}

/**
 * 
 * @param {number} id Book ID
 * @returns {void}
 */
function askToRemove(id){
    var bookID, img, title, author, image, para, footer ;
    for (var book in cartJSON) {
        if (cartJSON[book].id == id) {
            bookID = cartJSON[book]['id'] ;
            img= cartJSON[book]['img'] ;
            title = cartJSON[book]['title'];
            author = cartJSON[book]['author'];
            image = "<img src='/storage/book_img/"+(img)+"' alt='"+title+"' onerror='loadDefaultImage(this)'/>";
            para =  "<p class='added'>Do you want to remove</p>"+
                         "<p class='title'>"+title+"</p>" +"<p class='by'> By </p>"+ "<p class='author'>"+author+"</p>"+
                         "<p class='added'>from your shopping cart?</p>";
             footer = "<p class='foot'><button class='btn btn-sm' data-dismiss='modal' onclick='removeBook("+bookID+")' >Yes</button> <button class='btn btn-sm' data-dismiss='modal'>No</button></p>";
            $('#modal').on('show.bs.modal', function(){
                $('#modal .modal-title').text("Remove book from shopping Cart.");
                $('#modal #left-body').html(image);
                $('#modal #right-body').html(para);
                $('#modal #right-body').append(footer);
                $('#modal .modal-footer').html('');
            });
            $('#modal').modal();			
        }
    }
}
/**
 * Removes selected book from shopping cart.
 * 
 * @param {number} id Book ID
 * @returns {void}
 */
function removeBook(id){
    $.get('/cart/delete/'+id, function(data, status) {
        cartJSON = data;
        updateCart();
    });
}
/**
 * This will display a modal to confirm the action of the user if the after they might have clicked on the 'empty cart' button.
 * If the user confirms their action by clicking yes on the dialogue then the emptyCart() function is called which emties the cart
 * 
 * @param {number} id Book ID
 * @returns {void}
 */
function askToEmpty(id){
    var para =  "<p class='added'>Do you want to empty your shopping cart?</p>";
    var footer = "<p class='foot'><button class='btn btn-sm' data-dismiss='modal' onclick='emptyCart()' >Yes</button> <button class='btn btn-sm' data-dismiss='modal'>No</button></p>";
    $('#modal').on('show.bs.modal', function(){
        $('#modal .modal-title').text("Remove all books from shopping Cart.");
        $('#modal #left-body').html('');
        $('#modal #right-body').html(para);
        $('#modal #right-body').append(footer);
        $('#modal .modal-footer').html('');
    });
    $('#modal').modal();
}
/**
 * Sends an AJAX request to the server to empty the shopping cart.
 * 
 * @returns {void}
 */
function emptyCart(){
    $.get('/cart/empty', function(data, status){
        cartJSON = data;
        updateCart()
    });
}

/*Implement toLocaleString() later to replace this' */

/*::::::::::::::::::::!!!Warning!!!::::::::::::::::::::::::::::::::*/
/**
 * The maximum digits that can be formated is 17digits in a number. The 18th digit and above may be converted to zero.
 * This is because of the use of the toString function which may behave un expectedly for large numbers.
 * e.g formatNumber(12345678912345678997, ' ') will return 1 234 567 891 234 568 000
 * 
 * @param {number}  number
 * @param {string} separator
 * @return {string}
 */
function formatNumber(number, seperator){	
    var str, arr, new_str, maxIndex, sep, x, y;
    str = number.toString();
    arr = str.split('');
    new_str='';
    maxIndex = arr.length-1;
    seperate = (seperator==undefined)? ',' : seperator;
    x = maxIndex;
    y = 0;
    while (x>=0) {
        sep =''; 
        if (y >= 3) {
            sep = ((y%3)==0)? seperate :'';	
        }
        new_str = arr[x]+sep+new_str;
        x--;
        y++;
    }
    return new_str;
}

/**
 * The tooltip is initialized with a local onmouseover event which calls the showToolTip() function.
 * 
 * @returns {void}
 */
function showToolTip(){
    $('[data-toggle="tooltip"]').tooltip({
        placement:'bottom'
    });
}

/**
 * Generating a random array index to randomize the display of the rows on the index page. 
 * The categories are made to appear in random order each time the index page load.
 * 
 * @param {array} arry
 * @returns {number}
 */
function randomArrayIndex(arry){
    return Math.floor(Math.random()*arry.length)
}

/**
* Gets the object size of a JSON object.
* 
* @param {object} obj 
* @returns {integer} The size of the object.
*/
function getObjSize(obj){
    var size = 0;
    for(var items in obj){
        size++;
    }
    return size;
}

/**
 * Calculates the number of books in the shopping cart.
 * 
 * @returns  {number} 
 */
function getNoOfBooks(){
    var n = 0;
    for (var book in cartJSON) {
        num = cartJSON[book].copies
        n += parseInt(num);
    }
    return n;
}

/**
 * Calculates the total cost books in the shopping cart.
 * 
 * @returns {string}
 */
function getTotalPrice(){
    price = 0;
    for (var book in cartJSON) {
        price+= parseFloat(cartJSON[book].price);		
    }
    return formatNumber(price); //formatNumber(number, seperator) is a custom function defined else where.
}

/**
 * Redirect the user to the checkout page when they click the checkout button.
 * 
 * @returns {void}
 */
function checkOut(){
    window.location = '/cart/checkout';
}
/**
 * This will load a default image default.png if the book image can not be found.
 * 
 * @param {object} elem
 * @returns {void}
 */
function loadDefaultImage(elem){
    elem.onerror = null; //Prevents an infinite loop
    elem.src = '/img/book_img/default.png';
}

/**
 * Change the state of an HTML imput element from readyonly to writeable/editable.
 * 
 * @param {object} elem
 * @returns {void}
 */
function changeState(elem){
    $(elem).removeAttr('readonly');
    //elem.removeAttribute('readonly'); //Raw JS
}

/**
 * Update quantity of an item in the shopping cart when user changes it's quantity value.
 * 
 * @param {object} elem
 * @returns {void}
 */
function changeQuantity(elem){
    var copies = $(elem).val();
    var bookID = $(elem).attr('data-bookID');
    $.post('/cart/update', {"id":bookID, "copies":copies}, function(data, status){
        cartJSON = data;
        updateCart();
    });
}


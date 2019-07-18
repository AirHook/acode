										
										<?php
										/**********
										 * Current state is to show by default.
										 * To change to hidden first and then a click on the
										 * read more link above this section will show it,
										 * add style="display:none" to the div tag 
										 */
										?>
										<div class='readmore is-active'>
									
											<?php
											/**********
											 * BRIDAL ITEMS
											 */
											?>
											<?php if (
												$this->uri->uri_string() === 'apparel/bridal_dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(1) === 'bridal_dresses')
											): ?>
											
											A wedding dress or wedding gown is the clothing worn by a bride during a wedding ceremony. Color, style and ceremonial importance of the gown can depend on the religion and culture of the wedding participants. Most brides choose a dress of white to symbolize purity of the soul.
											<br /><br />
											Most brides decide on their wedding dress about 11 months prior to the wedding.Whether you’ve been dreaming of a fabulous lace gown or even a simple bohemain dress for your ceremony on some far off beach, we invite you to browse our collection of gowns and to take advantage of our CUSTOM ORDER service where we can make that dress to your exact measure and taste.
											<br /><br />
											At Basix Bridal, we invite you to share with our design team the vision of whatever your ideal dress may be, and to view our PINTEREST page for even more inspiration. If you're particularly drawn to a fashion trend either futuristic or from the past, our in house design and sample making room and staff can help you achieve your vision. The quality and beauty of the Basix Bridal fabrics is as important to us as it is to you so we source only the best materials for the production department uses. Silks, laces, motifs of intricate patterns, shimmer, sequin, and other non traditional colors are within your reach. We are your private couturier and all our dresses are prices at reasonable prices.
											
											<?php elseif (
												$this->uri->uri_string() === 'apparel/bridesmaids_dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'bridesmaids_dresses')
											): ?>
											
											
											The bridesmaids are members of the bride's party in a wedding. A bridesmaid is typically a young woman, and often a close friend or sister. She attends to the bride on the day of a wedding or marriage ceremony.
											<br /><br />
											The Basix Bridal design team offers a wide selection of styles and colors to flatter the bride and still be chic and elegant on their own. We offer traditional, modern, vintage and other inspired looks and design elements to give each bridesmaids her own unique style.
											<br /><br />
											Often there is more than one bridesmaid and to that end we at Basix Bridal try to address each of the individuals needs for fit and taste.
											
											<?php elseif (
												$this->uri->uri_string() === 'apparel/maid_of_honor_dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'maid_of_honor_dresses')
											): ?>
											
											
											Where to begin? From the moment she accepts the position as head attendant, the Maid of Honor (MOH) is expected to remain involved in just about every facet of wedding planning—plus, acts pretty much as the go-to person on the actual Big Day.
											<br /><br />
											The Basix Bridal collection offers this very special person a wide selection of styles and colors to flatter the bride as well as make her feel confident and elegant. 

											<?php elseif (
												$this->uri->uri_string() === 'apparel/mother_of_bride_groom_dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'mother_of_bride_groom_dresses')
											): ?>
											
											
											From the dress to the flowers to the cake, it's the second-most important event of a woman's life. You've had your Big Day, now it's your daughter's time to shine.
											<br /><br />
											Basix Bridal recognizes that all eyes will not only be on the lovely child you have nurtured for this big day but on you as well.
											<br /><br />
											To that end we offer Mother of Bride or Groom a wide selection of elegant flattering designs to make you shine on your proud and joyous day.

											<?php
											/**********
											 * BASIX ITEMS
											 */
											?>
											<?php elseif (
												$this->uri->uri_string() === 'apparel/evening-dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'evening-dresses')
											): ?>
											
											When you're going out, you want to stand out. Only a fabulous amazing dress will do the trick, and get you the attention you want. No matter what style you love, you will find it here. With options including shift, cami, halter, maxi, fit and flare, and even rompers. there is something for every style. Whether you prefer a sweet floral or edgy black lace is up to you, but you're sure to find something that works for your event. Whether you're looking for a classic dress for a dinner party with friends, or a sexy little number for date night, we've got you covered. With dresses in blue, pink, white, and black, there truly is something for any occasion. Keep it reserved, or make it playful and sexy with any of our choices of dresses for women. Add some statement jewelry, and an adorable purse, and you are ready for whatever the night brings. 
											
											<?php elseif (
												$this->uri->uri_string() === 'apparel/cocktail-dresses' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'cocktail-dresses')
											): ?>
											
											It's that time again. The weekend is calling, and so are the women's cocktail dresses in our collection. Whether it's poolside drinks, celebrating an engagement, or an anniversary dinner, we've got you. These party dresses for women know how to bring the fun with their lace details, strappy fronts, cut outs, and mesh inserts. With so many styles in so many colors, you're sure to find one that matches your needs perfectly. You'll look stunning.

											<?php elseif (
												$this->uri->uri_string() === 'apparel/tops' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'tops')
											): ?>
											
											Whether you are a skirt or dress pant kind of woman, the choice in tops is where you make your fashion stand. Our shirts and blouses come in a wide range of statement-making styles. You can't go wrong with the flattering shape and drape of our sequin, lace or linen tops. Available in a solid color palette or solid with contrast motifs, there are new patterns and designs added all the time. Our tops come in every sleeve length with a variety of necklines, hems and other special details. We can make them to order as your needs arise.
											
											<?php elseif (
												$this->uri->uri_string() === 'apparel/skirts' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'skirts')
											): ?>
											
											
											For an outfit that is perfect for any event, you can't go wrong with choosing from our selection of women's skirts. This is a piece of clothing that works for weddings, for work, or for play. Taking in a polo match or a local museum, Throw on one of our skirts, and a cute top and go fort it, you are dressed to impress.
											
											<?php elseif (
												$this->uri->uri_string() === 'apparel/shorts' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'shorts')
											): ?>
											
											
											When the weather heats up or the occasion warrants something truly chic, our dressy shorts hit the mark. With so many ways to wear them, you are sure to find something that fits your style and personality. We make shorts that are meant to be paired with a cute top to show just enough skin. Our shorts are meant to go with absolutely anything, so you can add your favorite shirt, and an adorable jacket or bolero for the evenings. Whether you are heading to a concert, nightclub, awards ceremony by night, or spending the day exploring a new city, our women's shorts are perfect for the occasion.

											<?php elseif (
												$this->uri->uri_string() === 'apparel/pants' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'pants')
											): ?>
											
											
											Dressing chic for a special event doesn't have to be boring anymore. Say goodbye to what you thought was evening casual, and say hello to our collection of women's dress pants. Instead of finding black pants that kind of fit, try our collection of black sequin dress pants or multi layer flare pants. They're classic, cute, and fit like they're supposed to. Find the style that works best for you; there are plenty of options for every wardrobe. Add a pair of heels, to complete the look.

											<?php elseif (
												$this->uri->uri_string() === 'apparel/jumpsuits' OR
												($this->uri->segment(1) === 'apparel' AND $this->uri->segment(2) === 'jumpsuits')
											): ?>
											
											
											You like your clothes to make a statement. You're not afraid to be original to your sense of style, and you know what you want in your wardrobe. Complete your statement with our women's jumpsuits. These are perfect for the cocktail party, opera or even a grand entrance to cannes film festival, as well as for the weekend gatherings with dear friends. You'll make a statement, and let everyone know you mean business. Step with confidence. Add a pair of heels, for the coup de grace.
											
											<?php endif; ?>
											
										</div>
										

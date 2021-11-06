<?php

use common\components\ImageClient;
use yii\helpers\Url;
use frontend\widgets\HomeProduct;
use frontend\widgets\ProductWidget;
use common\models\Area;
use common\models\Category;
use common\models\Urls;
use common\models\Banner;
use common\components\TextUtils;

$banner = Banner::find()->all();
?>
<div class="content">

	<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crumbs">
		<span typeof="v:Breadcrumb">
			<a rel="v:url" property="v:title" class="crumbs-home" href="/">Home</a></span> 
			<span class="delimiter">/</span> 
			<span class="current">Giới thiệu về quán Bánh Lọc Phương Thu</span>
		</div>
		<article class="post-listing post post-442 page type-page status-publish has-post-thumbnail hentry" id="the-post">
			<div class="post-inner">
				<h1 class="name post-title entry-title" itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Thing">
					<span itemprop="name">Giới thiệu</span>
				</h1>
				<p class="post-meta"></p>
				<div class="clear"></div>

				<div class="entry">
					<p>
						Bánh bột lọc từ lâu đã được giới trẻ và cả người lớn tuổi biết đến như một món ăn đặc sản của đất nước Việt Nam xinh đẹp nói chung, của cố đô Huế, Quảng Bình và thủ đô Hà Nội nói riêng. Món ăn này cũng đã từng được giới thiệu là một trong 30 món bánh ngon nhất thế giới, có khả năng “chinh phục” những thực khách khó tính nhất. Bánh bột lọc ban đầu có nguồn gốc từ Huế. Tuy nhiên, do quá trình di cư của người một số người gốc Huế ra Quảng Bình làm ăn, sinh sống, đã mang theo chiếc bánh này đến mảnh đất Quảng Bình. Sau đó, Bánh bột lọc đã được bàn tay khéo léo của những người phụ nữ xứ Quảng yêu lao động, giàu ý tưởng, sáng tạo nên chiếc bánh bột lọc mang đậm hương vị riêng của miền đất đầy gió Lào, cát trắng.
					</p>

					<p>
						Với tâm huyết của một người con Quảng Bình xa quê, mong muốn đưa món ăn đặc sản của quê hương mình đến với thực khách thủ đô, đồng thời giới thiệu với bạn bè, anh em miền Trung đang sinh sống và làm việc tại Hà Nội được thưởng thức ẩm thực của quê nhà. Hiệu bánh Phương Thu từ đó đã ra đời nhằm đáp ứng nhu cầu của các quý khách hàng đã dành trọn tình yêu đối với chiếc bánh này.
					</p>
					<p>
						Rất mong được quý khách hàng ủng hộ.
					</p>
					<p>Hiệu bánh Phương Thu trân trọng cảm ơn quý khách hàng đã đồng hành cùng Phương Thu!</p>

					<h4><span style="text-decoration: underline;"><strong>Bí quyết tạo nên sự hấp dẫn cho chiếc bánh Phương Thu</strong></span></h4>
					<ul>
						<li>
							Bánh được làm từ những nguyên liệu tự nhiên, sẵn có của quê nhà, đảm bảo an toàn vệ sinh thực phẩm, có lợi cho sức khỏe của người tiêu dùng.
							<ul>
								<li>Tôm đất sống ở vùng cửa sông đậm vị phù sa, bén độ mặn mòi của vị biển.</li>
								<li>Thịt ba chỉ được lấy từ nguồn chăn nuôi tự nhiên</li>
								<li>Bột bánh được làm từ củ sắn tươi, mài, lọc lấy tinh bột nguyên chất nên bánh mềm, dẻo, dai, trong suốt</li>
								<li>Măng rừng</li>
								<li>Hành tím ta</li>
							</ul>
						</li>
						<li>
							Bánh được gói bằng lá chuối xanh. Khi chín, bánh tỏa mùi thơm hấp dẫn của tôm, thịt, mộc nhĩ, măng rừng, hòa quyện với mùi lá chuối đã khiến không ít thực khách phải rong ruổi kiếm tìm khắp các ngõ ngách, con phố Hà Nội để thưởng thức cho bằng được món ăn dân dã này. 
						</li>
						<li>Bánh cung cấp đầy đủ 6 nhóm chất dinh dưỡng cơ bản, đảm bảo cho sức khỏe cho người tiêu dùng: đạm, xơ, béo, tinh bột, khoáng, canxi.</li>
						<li>Bánh bảo quản ngăn đông để được dài ngày (3 tuần) mà không cần phải rã đông khi hấp. Vì vậy quý khách có thể mua nhiều một lúc dùng dần, ăn lúc nào hấp lúc đấy thay cho bữa sáng, quà chiều rất tiện lợi.</li>
						<li>Không chỉ đem đến cho quý khách những mẻ bánh mang đậm chất Quảng Bình, Bánh bột lọc Phương Thu còn chăm chút kĩ lưỡng từ hình thức đóng gói, bảo quản sản phẩm cho đến việc chuẩn bị nước chấm đặc trưng, được pha chế theo công thức riêng (kèm theo từng gói hàng xinh xắn) để gửi đến cho quý khách.</li>
					</ul>



					<ul>
						<li>Sau khi nhận hàng, nếu chưa sử dụng ngay, quý khách nên để bánh vào ngăn đông tủ lạnh. Khi lấy hấp, không rã đông, bánh sẽ ngon hơn nhiều.</li>
						<li>Bánh sống: hấp cách thủy 30 phút đến khi thấy bánh mềm, toàn bộ lá bánh chuyển màu sậm, tỏa mùi thơm của tôm thịt hòa quyện mùi lá chuối, bột bánh trong suốt là được.</li>
						<li>Ăn nóng cùng với nước chấm đặc trưng của cửa hàng hoặc tương ớt.</li>
						<li>Bánh đã hấp chín bị nguội: Quý khách hấp cách thủy 10 phút là được.</li>
						<li>Không sử dụng lò vi sóng để làm nóng, bánh sẽ giảm độ ngon.</li>
					</ul>


					<h4><span style="text-decoration: underline;"><strong>Thời gian sử dụng bánh</strong></span></h4>
					<p>Do được làm từ những nguyên liệu hoàn toàn từ tự nhiên và không sử dụng chất bảo quản nên thời gian sử dụng Bánh bột lọc Phương Thu được khuyến cáo như sau:</p>

					<ul>
						<li>Đối với bánh để ngăn đông: thời hạn sử dụng từ 15 đến 20 ngày</li>
						<li>Đối với bánh để ngăn mát: thời hạn sử dụng 2 ngày</li>
					</ul>

					<h4><span style="text-decoration: underline;"><strong>Thời gian giao hàng</strong></span></h4>
					<ul>
						<li>Nhận đặt hàng: Từ 7h00 đến 21h00 hàng ngày</li>
						<li>Giao hàng: Từ 9h đến 20h hàng ngày</li>
					</ul>

					<p>
						Do Phương Thu chỉ cung cấp loại bánh tươi mới, đảm bảo uy tín, chất lượng, khách đặt lúc nào, làm lúc đấy. Vì vậy, với đơn hàng số lượng lớn (từ 1000 cái trở lên), đề nghị quý khách vui lòng đặt hàng trước 4 ngày (giao Hà Nội), trước 6 ngày (giao đi các tỉnh).
					</p>
					<p>
						Cửa hàng phục vụ cung cấp sản phẩm quanh năm. Chỉ nghỉ 07 ngày tết nguyên đán.
					</p>

					<h4><span style="text-decoration: underline;"><strong>Chính sách giao hàng</strong></span></h4>

					<ul>
						<li>Cửa hàng chỉ nhận ship đối với các đơn hàng từ 50 cái trở lên. Phí ship, quý khách vui lòng thanh toán với bên ship.</li>
						<li>Cửa hàng miễn phí ship đối với các đơn hàng sau:</li>
						<ul>
							<li>Bán kính dưới 10km: Đơn hàng từ 200 cái trở lên,</li>
							<li>Bán kính 10km đến 15km: Đơn hàng từ 300 cái trở lên, hình thức giao hàng tiết kiệm.</li>
							<li>Phạm vi ngoại thành Hà Nội: Đơn hàng từ 500 cái trở lên, hình thức giao hàng tiết kiệm.</li>
							<li>Đơn hàng đi các tỉnh: Số lượng từ 1000 cái trở lên, hình thức giao hàng tiết kiệm.</li>
						</ul>
					</ul>
					<h4><span style="text-decoration: underline;"><strong>Chính sách ưu đãi, giảm giá</strong></span></h4>

					<ul>
						<li>Cửa hàng có chính sách giảm giá 10% cho các đơn hàng lấy số lượng bánh lớn (từ 1000 cái trở lên).</li>
						<li>Nhằm tri ân đến các khách hàng đã dành sự yêu mến, tin tưởng đối với Bánh bột lọc Phương Thu, cửa hàng cũng có chính sách khuyến mại, giảm giá cho các khách hàng thân thiết, thường xuyên sử dụng bánh của cửa hàng.</li>
						<li>Cửa hàng có các chương trình khuyến mại, giảm giá vào các ngày lễ, Tết. Đề nghị quý khách hàng theo dõi trực tiếp trên Website hoặc trang Fanpage của cửa hàng.
						</li>
					</ul>

					<h3>Bánh Lọc Phương Thu. <br> Điểm đến tin cậy của quý khách hàng!</h3>

				</div><!-- .entry /-->	

				<div class="clear"></div>
			</div><!-- .post-inner -->
		</article><!-- .post-listing -->


	</div>
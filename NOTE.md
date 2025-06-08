## Sao chép Module

-   web (routes)
-   Controller
-   Model
-   Repository
-   Services
-   Config
-   Request
-   View

## Phân tích Module USER:

users:

-   id: PRIMARY KEY AUTO INCREMENT
-   email: varchar(255)
-   fullname: varchar 50
-   phone: varchar 20
-   province_i: varchar10
-   district_id: varchar 10
-   ward_id: varchar10
-   address: varchar 10
-   birthday: datetime
-   image: varchar 255
-   description: text
-   user_agent: text
-   ip: varchar 20
-   deleted_at: timestamp
-   user_catalogue_id: bigint(20) - Foreign key tham chiếu đến id bảng user_catalogues

Tạo bảng user_catalogues

-   id: PRIMARY KEY AUTO INCREMENT
-   name: varchar 50
-   description: text
-   deleted_at: timestamp

## Phân tích Module POST:

Module Post:

-   post_catalogues: Lưu các nhóm bài viết: tin tức, thời sự, bóng đá, vv...
-   posts: Lưu chi tiết các bài viết: messi ghi bàn, ...,
-   post_catalogue_post: pivot quan hệ giữa 2 bảng post_catalogues và bảng posts (Quan hệ n - n)
-   languages: lưu ngôn ngữ
-   post_catalogue_language: Lưu quan hệ giữa post_catalgoues và languages (n - n)
-   post_language: Lưu quan hệ giữa posts và languages (n - n)

languages:

-   id
-   name
-   canonical (unique)
-   image
-   user_id
-   deleted_at

post_catalogues:

-   id
-   parent_id (lưu mã danh mục cha)
-   left (giá trị bên trái của node)
-   right (giá trị bên phải của node)
-   level (cấp độ của danh mục)
-   image
-   icon
-   album (danh sách ảnh)
-   publish
-   follow
-   order (sắp xếp danh mục)
-   user_id (Người tạo ra danh mục)
-   deleted_at

post_catalogue_language:

-   post_catalogue_id
-   language_id
-   name (tên nhóm bài viết)
-   description: null (mô tả ngắn)
-   canonical: unique (đường dẫn truy cập vào danh mục)
-   content: null (nội dung của danh mục)
-   meta_title: tiêu đề SEO
-   meta_description: mô tả SEO
-   meta_keyword: từ khoá SEO

posts:

-   id
-   post_catalogue_id
-   image
-   icon
-   album
-   order
-   publish
-   follow
-   deleted_at
-   user_id

post_catalogue_post:

-   post_id
-   post_catalogue_id
-   name
-   description
-   canonical
-   content
-   viewed
-   meta_title: tiêu đề SEO
-   meta_description: mô tả SEO
-   meta_keyword: từ khoá SEO

Tạo ra bảng routers để lưu các url

-   id
-   canonical
-   module_id
-   created_at
-   updated_at
-   deleted_at
-   controllers

import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { useRoute } from 'wouter';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';
import { blogPosts } from './blog-page';

// Interface untuk komentar blog
interface Comment {
  id: string;
  author: string;
  authorAvatar: string;
  content: string;
  date: string;
  likes: number;
  isLiked: boolean;
  parentId: string | null;
  replies: Comment[];
}

// Interface untuk komentar datar (sebelum distruktur sebagai tree)
interface FlatComment {
  id: string;
  author: string;
  authorAvatar: string;
  content: string;
  date: string;
  likes: number;
  isLiked: boolean;
  parentId: string | null;
}

// Data dummy untuk komentar blog
const dummyFlatComments: FlatComment[] = [
  {
    id: "c1",
    author: "Budi Setiawan",
    authorAvatar: "https://i.pravatar.cc/150?img=1",
    content: "Artikel ini sangat membantu saya memahami manfaat kartu kredit. Terima kasih atas informasinya!",
    date: "12 Mei 2023 • 10:25",
    likes: 8,
    isLiked: false,
    parentId: null
  },
  {
    id: "c2",
    author: "Siti Rahayu",
    authorAvatar: "https://i.pravatar.cc/150?img=5",
    content: "Saya juga menggunakan strategi ini dan berhasil meningkatkan poin reward saya hingga 30%. Sangat direkomendasikan!",
    date: "12 Mei 2023 • 13:10",
    likes: 5,
    isLiked: false,
    parentId: null
  },
  {
    id: "c3",
    author: "Ahmad Fadli",
    authorAvatar: "https://i.pravatar.cc/150?img=3",
    content: "Bisakah dijelaskan lebih detail tentang cara mendapatkan poin dari transaksi online?",
    date: "13 Mei 2023 • 09:15",
    likes: 2,
    isLiked: false,
    parentId: null
  },
  {
    id: "c4",
    author: "Admin Mileage",
    authorAvatar: "https://i.pravatar.cc/150?img=11",
    content: "Tentu Ahmad, untuk transaksi online biasanya Anda akan mendapatkan poin sebanyak 2-3x lipat dibandingkan transaksi offline. Pastikan Anda memilih merchant yang bekerja sama dengan penerbit kartu Anda untuk hasil maksimal.",
    date: "13 Mei 2023 • 10:30",
    likes: 4,
    isLiked: false,
    parentId: "c3"
  },
  {
    id: "c5",
    author: "Ahmad Fadli",
    authorAvatar: "https://i.pravatar.cc/150?img=3",
    content: "Terima kasih atas penjelasannya! Akan saya coba.",
    date: "13 Mei 2023 • 11:05",
    likes: 1,
    isLiked: false,
    parentId: "c4"
  },
  {
    id: "c6",
    author: "Dewi Lestari",
    authorAvatar: "https://i.pravatar.cc/150?img=7",
    content: "Saya sudah mencoba metode ini selama 3 bulan dan berhasil mendapatkan cashback yang signifikan. Sangat direkomendasikan untuk pemula!",
    date: "14 Mei 2023 • 14:20",
    likes: 3,
    isLiked: false,
    parentId: null
  },
  {
    id: "c7",
    author: "Rudi Hermawan",
    authorAvatar: "https://i.pravatar.cc/150?img=9",
    content: "Berapa minimum transaksi yang direkomendasikan untuk memaksimalkan poin?",
    date: "15 Mei 2023 • 08:45",
    likes: 0,
    isLiked: false,
    parentId: "c2"
  },
  {
    id: "c8",
    author: "Siti Rahayu",
    authorAvatar: "https://i.pravatar.cc/150?img=5",
    content: "Dari pengalaman saya, sekitar 3-5 juta rupiah per bulan sudah cukup optimal. Lebih dari itu, manfaatnya tidak terlalu signifikan kecuali Anda memiliki kartu premium.",
    date: "15 Mei 2023 • 10:30",
    likes: 2,
    isLiked: false,
    parentId: "c7"
  }
];

// Fungsi untuk mengubah komentar datar menjadi struktur tree
const buildCommentTree = (flatComments: FlatComment[]): Comment[] => {
  const commentMap: Record<string, Comment> = {};
  const tree: Comment[] = [];

  // Pertama, buat semua komentar dengan replies kosong
  flatComments.forEach(comment => {
    commentMap[comment.id] = {
      ...comment,
      replies: []
    };
  });

  // Kemudian, masukkan replies ke parent masing-masing
  flatComments.forEach(comment => {
    if (comment.parentId) {
      commentMap[comment.parentId].replies.push(commentMap[comment.id]);
    } else {
      tree.push(commentMap[comment.id]);
    }
  });

  return tree;
};

// Komponen untuk setiap komentar
const CommentItem = ({ 
  comment, 
  onLike, 
  onReply,
  level = 0
}: { 
  comment: Comment; 
  onLike: (id: string) => void;
  onReply: (parentId: string, parentAuthor: string) => void;
  level?: number;
}) => {
  return (
    <div className="relative">
      <div className={`relative ${level > 0 ? 'pl-6 ml-6 border-l border-border' : ''}`}>
        <div className="flex space-x-4 mb-4">
          <img 
            src={comment.authorAvatar} 
            alt={comment.author} 
            className="w-10 h-10 rounded-full border border-border flex-shrink-0"
          />
          <div className="flex-1">
            <div className="bg-foreground/5 rounded-lg p-4">
              <div className="flex justify-between items-start mb-2">
                <h4 className="font-medium text-foreground">{comment.author}</h4>
                <span className="text-xs text-muted-foreground">{comment.date}</span>
              </div>
              <p className="text-sm text-foreground mb-3">{comment.content}</p>
              <div className="flex items-center space-x-4 text-xs text-muted-foreground">
                <button 
                  className={`flex items-center space-x-1 ${comment.isLiked ? 'text-blue-500' : 'hover:text-blue-500'}`}
                  onClick={() => onLike(comment.id)}
                >
                  <i className={`${comment.isLiked ? 'ri-heart-fill' : 'ri-heart-line'}`}></i>
                  <span>{comment.likes}</span>
                </button>
                <button 
                  className="flex items-center space-x-1 hover:text-blue-500"
                  onClick={() => onReply(comment.id, comment.author)}
                >
                  <i className="ri-chat-1-line"></i>
                  <span>Balas</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {comment.replies.length > 0 && (
        <div className="mt-1">
          {comment.replies.map(reply => (
            <CommentItem 
              key={reply.id} 
              comment={reply} 
              onLike={onLike} 
              onReply={onReply}
              level={level + 1}
            />
          ))}
        </div>
      )}
    </div>
  );
};

// Komponen utama halaman detail blog
const BlogDetailPage: React.FC = () => {
  const [, params] = useRoute<{ id: string }>('/blog-detail/:id');
  const postId = params?.id ? parseInt(params.id) : 1;
  const post = blogPosts.find((p: any) => p.id === postId) || blogPosts[0];
  
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [commentTree, setCommentTree] = useState<Comment[]>([]);
  const [commentText, setCommentText] = useState('');
  const [replyTo, setReplyTo] = useState<{ id: string; author: string } | null>(null);
  const [isLiked, setIsLiked] = useState(false);
  const [likeCount, setLikeCount] = useState(124);
  
  // Load komentar saat halaman dimuat
  useEffect(() => {
    const tree = buildCommentTree(dummyFlatComments);
    setCommentTree(tree);
  }, []);
  
  // Handle like pada blog post
  const handleBlogLike = () => {
    setIsLiked(!isLiked);
    setLikeCount(prev => isLiked ? prev - 1 : prev + 1);
  };
  
  // Handle like pada komentar
  const handleCommentLike = (commentId: string) => {
    const updateComments = (comments: Comment[]): Comment[] => {
      return comments.map(comment => {
        if (comment.id === commentId) {
          return {
            ...comment,
            isLiked: !comment.isLiked,
            likes: comment.isLiked ? comment.likes - 1 : comment.likes + 1
          };
        } else if (comment.replies.length > 0) {
          return {
            ...comment,
            replies: updateComments(comment.replies)
          };
        }
        return comment;
      });
    };
    
    setCommentTree(prev => updateComments(prev));
  };
  
  // Handle reply pada komentar
  const handleReply = (parentId: string, parentAuthor: string) => {
    setReplyTo({ id: parentId, author: parentAuthor });
  };
  
  // Cancel reply
  const cancelReply = () => {
    setReplyTo(null);
  };
  
  // Handle submit komentar/reply
  const handleSubmitComment = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!commentText.trim()) return;
    
    const newComment: FlatComment = {
      id: `c${Date.now()}`,
      author: "Anda",
      authorAvatar: "https://i.pravatar.cc/150?img=30",
      content: commentText,
      date: new Date().toLocaleString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).replace('pukul', '•'),
      likes: 0,
      isLiked: false,
      parentId: replyTo ? replyTo.id : null
    };
    
    const updatedComments = [...dummyFlatComments, newComment];
    setCommentTree(buildCommentTree(updatedComments));
    setCommentText('');
    setReplyTo(null);
  };

  return (
    <div className="min-h-screen overflow-x-hidden bg-background">
      <Header onMobileMenuToggle={() => setIsMobileMenuOpen(!isMobileMenuOpen)} />
      
      <main className="pt-24 pb-20 px-4">
        <div className="max-w-4xl mx-auto">
          <article className="bg-background border border-border/50 rounded-xl overflow-hidden shadow-lg">
            {/* Post header image */}
            <div className="relative h-64 md:h-96">
              <img 
                src={post.imageUrl} 
                alt={post.title}
                className="w-full h-full object-cover"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-background/90 via-background/50 to-transparent"></div>
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-blue-600/90 backdrop-blur-sm rounded-full text-white text-xs font-medium shadow-lg mb-3">
                  {post.category}
                </span>
                <h1 className="text-2xl md:text-4xl font-bold text-white drop-shadow-md">
                  {post.title}
                </h1>
              </div>
            </div>
            
            {/* Post metadata */}
            <div className="flex items-center justify-between p-6 border-b border-border">
              <div className="flex items-center">
                <img 
                  src={post.authorAvatar} 
                  alt={post.author}
                  className="w-10 h-10 rounded-full border border-border mr-3"
                />
                <div>
                  <h3 className="font-medium">{post.author}</h3>
                  <div className="text-sm text-muted-foreground">
                    {post.date} • {post.readTime}
                  </div>
                </div>
              </div>
              
              <div className="flex items-center space-x-3">
                <button 
                  className={`flex items-center space-x-1 px-3 py-1 rounded-full ${isLiked ? 'bg-red-100 text-red-500' : 'bg-foreground/10 text-muted-foreground hover:bg-foreground/20'}`}
                  onClick={handleBlogLike}
                >
                  <i className={`${isLiked ? 'ri-heart-fill' : 'ri-heart-line'}`}></i>
                  <span>{likeCount}</span>
                </button>
                <button className="flex items-center space-x-1 px-3 py-1 rounded-full bg-foreground/10 text-muted-foreground hover:bg-foreground/20">
                  <i className="ri-share-line"></i>
                  <span>Bagikan</span>
                </button>
              </div>
            </div>
            
            {/* Post content */}
            <div className="p-6 md:p-8">
              <div className="prose prose-blue dark:prose-invert max-w-none">
                <p className="text-lg font-medium mb-6">{post.excerpt}</p>
                
                <h2>Mengoptimalkan Penggunaan Kartu Kredit</h2>
                <p>Kartu kredit bukan sekadar alat pembayaran, tetapi juga merupakan instrumen keuangan yang bisa memberikan banyak manfaat jika digunakan dengan bijak. Penggunaan kartu kredit yang cerdas dapat menghasilkan reward points, cashback, dan berbagai keuntungan lain yang jarang dimanfaatkan secara maksimal oleh kebanyakan pemegang kartu.</p>
                
                <h3>Strategi Mengumpulkan Poin</h3>
                <p>Untuk memaksimalkan poin reward dari kartu kredit Anda, perhatikan kategori belanja yang memberikan poin lebih tinggi. Misalnya, beberapa kartu kredit menawarkan poin ganda untuk pembelian bahan bakar, sementara yang lain memberikan poin lebih banyak untuk belanja di supermarket atau restoran.</p>
                
                <ul>
                  <li>Pilih kartu kredit yang sesuai dengan pola belanja Anda</li>
                  <li>Konsentrasikan pengeluaran pada satu atau dua kartu utama</li>
                  <li>Manfaatkan promo poin berlipat dari bank</li>
                  <li>Bayar tagihan rutin dengan kartu kredit</li>
                  <li>Selalu bayar tagihan tepat waktu untuk menghindari biaya bunga</li>
                </ul>
                
                <h3>Menukar Poin dengan Bijak</h3>
                <p>Setelah berhasil mengumpulkan poin, langkah selanjutnya adalah menukarnya dengan bijak. Analisis nilai tukar poin untuk berbagai penawaran dan pilih yang memberikan nilai terbaik. Biasanya, penukaran dengan miles penerbangan atau voucher belanja memberikan nilai yang lebih tinggi dibandingkan dengan penukaran cashback langsung.</p>
                
                <figure>
                  <blockquote>
                    <p>"Kunci utama dalam memaksimalkan poin reward adalah konsistensi dan pengelolaan yang tepat. Fokus pada satu sistem reward dan kuasai mekanismenya."</p>
                  </blockquote>
                  <figcaption>
                    — Budi Santoso, Pakar Keuangan Personal
                  </figcaption>
                </figure>
                
                <h3>Memahami Jadwal Kedaluwarsa Poin</h3>
                <p>Salah satu kesalahan umum pemegang kartu kredit adalah mengabaikan tanggal kedaluwarsa poin rewards. Sebagian besar poin memiliki masa berlaku antara 2-3 tahun. Pastikan Anda mencatat dan mengatur strategi penukaran sebelum poin-poin tersebut hangus.</p>
                
                <h2>Keuntungan Tambahan yang Sering Terabaikan</h2>
                <p>Selain poin reward, kartu kredit modern juga menawarkan beragam manfaat lain seperti:</p>
                
                <ul>
                  <li>Asuransi perjalanan gratis</li>
                  <li>Perlindungan pembelian</li>
                  <li>Akses lounge bandara</li>
                  <li>Concierge service</li>
                  <li>Diskon di merchant tertentu</li>
                </ul>
                
                <p>Manfaatkan keuntungan-keuntungan ini untuk mendapatkan nilai lebih dari biaya tahunan yang Anda bayarkan untuk kartu kredit premium.</p>
                
                <h2>Kesimpulan</h2>
                <p>Dengan strategi yang tepat, kartu kredit bukan lagi menjadi sumber beban keuangan tetapi justru bisa menjadi alat yang menguntungkan. Kuncinya adalah disiplin dalam penggunaan, pemahaman mendalam tentang program rewards, dan perencanaan penukaran poin yang matang.</p>
              </div>
            </div>
            
            {/* Related articles */}
            <div className="p-6 border-t border-border">
              <h3 className="text-lg font-bold mb-4">Artikel Terkait</h3>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                {blogPosts.slice(1, 4).map((relatedPost: any) => (
                  <a 
                    key={relatedPost.id} 
                    href={`/blog-detail/${relatedPost.id}`}
                    className="group block"
                  >
                    <div className="relative h-32 rounded-lg overflow-hidden mb-2">
                      <img 
                        src={relatedPost.imageUrl} 
                        alt={relatedPost.title}
                        className="w-full h-full object-cover transition-transform group-hover:scale-105 duration-300"
                      />
                      <div className="absolute inset-0 bg-gradient-to-t from-background/70 to-transparent"></div>
                    </div>
                    <h4 className="font-medium text-sm group-hover:text-blue-500 transition-colors line-clamp-2">
                      {relatedPost.title}
                    </h4>
                  </a>
                ))}
              </div>
            </div>
          </article>
          
          {/* Comments section */}
          <div className="mt-8 bg-background border border-border/50 rounded-xl overflow-hidden shadow-lg">
            <div className="p-6 border-b border-border">
              <h3 className="text-lg font-bold">Komentar ({commentTree.length + commentTree.reduce((acc, comment) => acc + comment.replies.length, 0)})</h3>
            </div>
            
            {/* Comment form */}
            <div className="p-6 border-b border-border">
              <form onSubmit={handleSubmitComment}>
                {replyTo && (
                  <div className="mb-3 p-3 bg-blue-50 dark:bg-blue-950/30 rounded-lg flex justify-between items-center">
                    <span className="text-sm">
                      Membalas komentar <span className="font-medium">{replyTo.author}</span>
                    </span>
                    <button 
                      type="button" 
                      onClick={cancelReply}
                      className="text-muted-foreground hover:text-foreground"
                    >
                      <i className="ri-close-line"></i>
                    </button>
                  </div>
                )}
                
                <div className="flex space-x-4">
                  <img 
                    src="https://i.pravatar.cc/150?img=30" 
                    alt="Your avatar" 
                    className="w-10 h-10 rounded-full border border-border flex-shrink-0"
                  />
                  <div className="flex-1">
                    <textarea
                      className="w-full p-3 border border-border bg-background rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                      rows={3}
                      placeholder={replyTo ? `Balas ke ${replyTo.author}...` : "Tulis komentar Anda..."}
                      value={commentText}
                      onChange={(e) => setCommentText(e.target.value)}
                    ></textarea>
                    <div className="mt-2 flex justify-end">
                      <button 
                        type="submit"
                        className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        disabled={!commentText.trim()}
                      >
                        Kirim Komentar
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            
            {/* Comments list */}
            <div className="p-6">
              <div className="space-y-6">
                {commentTree.map(comment => (
                  <CommentItem 
                    key={comment.id} 
                    comment={comment} 
                    onLike={handleCommentLike} 
                    onReply={handleReply}
                  />
                ))}
              </div>
            </div>
          </div>
        </div>
      </main>
      
      <MobileMenu isOpen={isMobileMenuOpen} onClose={() => setIsMobileMenuOpen(false)} />
      <Footer />
    </div>
  );
};

export default BlogDetailPage;
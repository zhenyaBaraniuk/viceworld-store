import { Play } from "lucide-react";
import Lightbox from "yet-another-react-lightbox";
import Video from "yet-another-react-lightbox/plugins/video";
import Zoom from "yet-another-react-lightbox/plugins/zoom";
import "yet-another-react-lightbox/styles.css";
import { useRef, useState } from "react";
import type { Media } from "@/types/models/media";

type Props = {
    name: string;
    video: Media | null;
    images: Media[] | null;
    main_image: Media | null;
};

export default function ProductGallery({
    name,
    video,
    main_image,
    images,
}: Props) {
    const videoRef = useRef<HTMLVideoElement>(null);
    const [isPlaying, setIsPlaying] = useState(true);
    const [lightboxOpen, setLightboxOpen] = useState(false);
    const [lightboxIndex, setLightboxIndex] = useState(0);

    const togglePlay = () => {
        if (!videoRef.current) return;
        isPlaying ? videoRef.current.pause() : videoRef.current.play();
        setIsPlaying((prev) => !prev);
    };

    const openLightbox = (index: number) => {
        setLightboxIndex(index);
        setLightboxOpen(true);
    };

    const slides = [
        ...(video
            ? [
                  {
                      type: "video" as const,
                      sources: [{ src: video.url, type: video.mime_type }],
                  },
              ]
            : []),
        ...(images ?? []).map((img) => ({ src: img.url })),
    ];

    const imageSlideIndex = (index: number) => (video ? index + 1 : index);

    return (
        <>
            <div className="product-gallery__grid">
                {video ? (
                    <div className="product-gallery__video bg-surface-container-low group">
                        <video
                            className="product-gallery__video-video"
                            ref={videoRef}
                            onClick={togglePlay}
                            poster={main_image?.url}
                            autoPlay
                            muted
                            loop
                            playsInline
                        >
                            <source src={video?.url} type={video?.mime_type} />
                        </video>

                        <div className="product-gallery__badge bg-primary text-white  font-['Space_Grotesk']">
                            ▶ VIDEO
                        </div>

                        {!isPlaying && (
                            <div
                                onClick={togglePlay}
                                className="product-gallery__overlay bg-black/30 group-hover:bg-black/10"
                            >
                                <div className="product-gallery__play-btn bg-white rounded-full transform group-hover:scale-110">
                                    <Play size={12} />
                                </div>
                            </div>
                        )}

                        <div
                            className="product-gallery__controls bg-gradient-to-t from-black/60 to-transparent group-hover:opacity-100"
                            onClick={(e) => e.stopPropagation()}
                        >
                            <div className="flex space-x-4 items-center">
                                <span
                                    className="material-symbols-outlined text-white text-sm"
                                    onClick={togglePlay}
                                >
                                    {isPlaying ? "pause" : "play"}
                                </span>

                                <div className="product-gallery__progress bg-white/30 rounded-full">
                                    <div className="product-gallery__progress-fill bg-white" />
                                </div>

                                <span
                                    className="material-symbols-outlined text-white text-sm cursor-pointer"
                                    onClick={() => openLightbox(0)}
                                />
                            </div>
                        </div>
                    </div>
                ) : (
                    main_image && (
                        <div
                            className="product-gallery__thumb bg-surface-container-low cursor-pointer"
                            onClick={() => openLightbox(0)}
                        >
                            <img
                                className="product-gallery__thumb-img"
                                alt={name}
                                src={main_image?.url}
                            />
                        </div>
                    )
                )}

                {images?.map((image, index) => (
                    <div
                        key={image.id}
                        className="product-gallery__thumb bg-surface-container-low"
                        onClick={() => openLightbox(imageSlideIndex(1))}
                    >
                        <img
                            className="product-gallery__thumb-img"
                            alt={name}
                            src={image.url}
                        />
                    </div>
                ))}
            </div>

            <Lightbox
                open={lightboxOpen}
                close={() => setLightboxOpen(false)}
                index={lightboxIndex}
                slides={slides}
                plugins={[Video, Zoom]}
            />
        </>
    );
}

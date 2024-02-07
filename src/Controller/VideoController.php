<?php

namespace App\Controller;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/video', name: 'video.')]
class VideoController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(VideoRepository $videoRepository): Response
    {
        $videos = $videoRepository->findAll();

        return $this->render('video/index.html.twig', [
            'videos' => $videos
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $videoGeneratedId = substr(md5(mt_rand()), 0, 11);

        $video = new Video();

        $video->setVideoId($videoGeneratedId);
        $video->setTitle('Harry Potter');
        $video->setDescription('Test beschrijving');
        $video->setThumbnailName('hp.jpg');
        $video->setDuration(18);
        $video->setUploadDateTime(new \DateTime('now'));

        $em = $doctrine->getManager();
        $em->persist($video);
        $em->flush();

        return new Response('Video aangemaakt');
    }
    #[Route('/{videoId}', name: 'show')]
    public function show($videoId, Video $video): Response
    {
        return $this->render('video/show.html.twig',[
            'video' => $video
        ]);
    }
}

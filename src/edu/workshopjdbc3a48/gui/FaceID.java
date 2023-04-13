package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.util.List;
import org.opencv.core.Mat;

import org.opencv.core.Core;
import org.opencv.core.Mat;
import org.opencv.face.FaceRecognizer;

import org.opencv.core.MatOfRect;
import org.opencv.core.Rect;
import org.opencv.core.Size;
import org.opencv.imgcodecs.Imgcodecs;
import org.opencv.imgproc.Imgproc;
import org.opencv.objdetect.CascadeClassifier;
import org.opencv.videoio.VideoCapture;

import javafx.application.Application;
import javafx.geometry.Insets;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;
import org.bytedeco.javacpp.opencv_core;
import org.bytedeco.javacpp.opencv_core.MatVector;
import org.opencv.core.MatOfByte;
import org.opencv.core.Scalar;

public class FaceID extends Application {

    private static final String CASCADE_CLASSIFIER_FILE = "C:\\opencv\\sources\\samples\\winrt_universal\\VideoCaptureXAML\\video_capture_xaml\\video_capture_xaml.Windows\\Assets\\haarcascade_frontalface_alt.xml";
    private static final String KNOWN_FACE_FILE = "C:\\knownFaces\\Kno.jpg";
    private static final int IMAGE_WIDTH = 200;
    private static final int IMAGE_HEIGHT = 200;

    private CascadeClassifier faceDetector;
    private ImageView capturedImageView;
     private ImageView capturedImageView2;
    private Label statusLabel;
    private Mat capturedImage;
    private Mat knownFace;
private  List<Utilisateur> l = null ;
    
    public static void main(String[] args) {
        launch(args);
    }

  
    @Override
    public void start(Stage primaryStage) throws Exception {
        // Load the OpenCV library
        System.loadLibrary(Core.NATIVE_LIBRARY_NAME);

        // Load the face detector
        faceDetector = new CascadeClassifier(CASCADE_CLASSIFIER_FILE);

    
        // Load the known face
        
        knownFace = Imgcodecs.imread(KNOWN_FACE_FILE);

        // Create the UI
        capturedImageView = new ImageView();
        Button captureButton = new Button("Capture");
        captureButton.setOnAction(e -> captureImage());
        statusLabel = new Label("Please capture your face");

        VBox vbox = new VBox(10, capturedImageView, captureButton, statusLabel);
        vbox.setPadding(new Insets(10));

        Scene scene = new Scene(vbox);

        primaryStage.setScene(scene);
        primaryStage.show();
    }

    private void captureImage() {
        // Create the capture window
        Stage captureWindow = new Stage();
        
        captureWindow.initModality(Modality.APPLICATION_MODAL);
        captureWindow.setTitle("Capture Face");

        // Create the UI for the capture window
        capturedImageView = new ImageView();
        Button captureImageButton = new Button("Capture");
        captureImageButton.setOnAction(e -> {
            // Capture the image from the webcam
            VideoCapture capture = new VideoCapture(0);
            Mat image = new Mat();
            capture.read(image);

            // Display the captured image
            capturedImageView.setImage(mat2Image(image));
//capturedImageView2.setImage(mat2Image(knownFace));
            // Detect faces in the captured image
            MatOfRect faceDetections = new MatOfRect();
            faceDetector.detectMultiScale(image, faceDetections);

            if (faceDetections.toArray().length == 0) {
                statusLabel.setText("No face detected");
                return;
            }

            // Extract the first face detected
            Rect face = faceDetections.toArray()[0];
            Mat faceImage = new Mat(image, face);

            // Resize the face image to a standard size
           // Imgproc.resize(faceImage, faceImage, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));
            //Imgproc.cvtColor(faceImage, faceImage, Imgproc.COLOR_BGR2GRAY);

            // Compare the captured face to the known face
            
           
            
             
              knownFace=Imgcodecs.imread(KNOWN_FACE_FILE);
               
            if (compareFaces(faceImage, knownFace)) {
                
                System.out.println("Worked");
} else {

 System.out.println("not Worked");
}
           // Release the video capture
        capture.release();
  
        });

    HBox hbox = new HBox(10, capturedImageView, captureImageButton);
    hbox.setPadding(new Insets(10));

    Scene scene = new Scene(hbox);

    captureWindow.setScene(scene);
    captureWindow.show();
}

private boolean compareFaces(Mat face1, Mat face2) {
   
        if (compareImages(face1, face2)) {
            // Face recognized, do something with user data
            System.out.println("Face knowed ");
            return true;
        
    }

    // Face not recognized
    System.out.println("Face NOT kNOWN");
    return false;
}


private Image mat2Image(Mat mat) {
    // Convert the Mat object to an Image object
    return Utils.mat2Image(mat);
}     
private boolean compareImages(Mat image1, Mat image2) {
    // Convert the images to grayscale
    Mat grayImage1 = new Mat();
    Mat grayImage2 = new Mat();
    Imgproc.cvtColor(image1, grayImage1, Imgproc.COLOR_BGR2GRAY);
    Imgproc.cvtColor(image2, grayImage2, Imgproc.COLOR_BGR2GRAY);

    // Detect faces in the images
    MatOfRect faceDetections1 = new MatOfRect();
    faceDetector.detectMultiScale(grayImage1, faceDetections1);
    MatOfRect faceDetections2 = new MatOfRect();
    faceDetector.detectMultiScale(grayImage2, faceDetections2);

    // Return false if no faces are detected in either image
    if (faceDetections1.toArray().length == 0 || faceDetections2.toArray().length == 0) {
        return false;
    }

    // Extract the first face detected in each image
    Rect face1 = faceDetections1.toArray()[0];
    Rect face2 = faceDetections2.toArray()[0];
    Mat croppedFace1 = new Mat(grayImage1, face1);
    Mat croppedFace2 = new Mat(grayImage2, face2);

    // Resize the faces to a standard size
    Imgproc.resize(croppedFace1, croppedFace1, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));
    Imgproc.resize(croppedFace2, croppedFace2, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));

    // Calculate the difference between the faces
    Mat diff = new Mat();
    Core.absdiff(croppedFace1, croppedFace2, diff);

    // Calculate the average pixel value difference
    Scalar mean = Core.mean(diff);
    double avgDiff = mean.val[0];

    // Return true if the difference is below a threshold
    return avgDiff < 20;
}

}

class Utils {
public static Image mat2Image(Mat mat) {
// Convert the Mat object to a byte array
MatOfByte byteMat = new MatOfByte();
Imgcodecs.imencode(".png", mat, byteMat);
byte[] byteArray = byteMat.toArray();
    // Convert the byte array to an Image object
    Image image = new Image(new ByteArrayInputStream(byteArray));

    return image;
}
}
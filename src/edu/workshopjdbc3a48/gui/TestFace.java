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
import org.bytedeco.javacpp.Pointer;
import org.bytedeco.javacpp.opencv_core;
import org.bytedeco.javacpp.opencv_core.MatVector;
import org.bytedeco.javacpp.opencv_core.MatPointer;


import org.opencv.core.MatOfByte;
import org.opencv.face.LBPHFaceRecognizer;

public class TestFace extends Application {

    private static final String CASCADE_CLASSIFIER_FILE = "C:\\opencv\\sources\\samples\\winrt_universal\\VideoCaptureXAML\\video_capture_xaml\\video_capture_xaml.Windows\\Assets\\haarcascade_frontalface_alt.xml";
    private static final String KNOWN_FACE_FILE = "C:\\knownFaces\\Known.jpg";
    private static final int IMAGE_WIDTH = 200;
    private static final int IMAGE_HEIGHT = 200;

    private CascadeClassifier faceDetector;
    private ImageView capturedImageView;
    private Label statusLabel;
    private Mat capturedImage;
    private Mat knownFace;
    private List<Utilisateur> l = null;

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

        // Detect faces in the captured image
        MatOfRect faceDetections = new MatOfRect();
        faceDetector.detectMultiScale(image, faceDetections);

        // If no faces were detected, show an error message and return
        if (faceDetections.toArray().length == 0) {
            statusLabel.setText("No face detected");
            return;
        }

        // Get the first face detected
        Rect face = faceDetections.toArray()[0];

        // Crop the image to only show the face
        capturedImage = new Mat(image, face);

        // Resize the image to a standard size
        Imgproc.resize(capturedImage, capturedImage, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));

        // Display the cropped and resized image
        capturedImageView.setImage(mat2Image(capturedImage));

        // Release the webcam capture
        capture.release();
    });

    HBox hbox = new HBox(10, capturedImageView, captureImageButton);
    hbox.setPadding(new Insets(10));

    Scene captureScene = new Scene(hbox);

    captureWindow.setScene(captureScene);
    captureWindow.showAndWait();

    // Check if the captured image matches the known face
    FaceRecognizer faceRecognizer = LBPHFaceRecognizer.create();
MatVector images = new MatVector(2);
opencv_core.Mat labels = new opencv_core.Mat(2, 1, opencv_core.CV_32SC1);
images.put(0, knownFace.asMat());
labels.put(0, 0, 1);
images.put(1, capturedImage.asMat());
labels.put(1, 0, 2);
faceRecognizer.train(images, labels);

    int[] prediction = new int[1];
    double[] confidence = new double[1];
    faceRecognizer.predict(capturedImage, prediction, confidence);

    // If the confidence is low, show an error message
    if (confidence[0] > 150) {
        statusLabel.setText("Unknown face");
        return;
    }

    // If the confidence is high enough, show the user's information
    int userId = prediction[0];
    ServiceUtilisateur su = new ServiceUtilisateur();
    l = su.rechercheById(userId);
    if (l != null) {
        Utilisateur u = l.get(0);
        statusLabel.setText("Welcome " + u.getPrenom() + " " + u.getNom());
    }
}

// Convert a Mat object to an Image object for displaying in JavaFX
private Image mat2Image(Mat mat) {
    MatOfByte buffer = new MatOfByte();
    Imgcodecs.imencode(".png", mat, buffer);
    return new Image(new ByteArrayInputStream(buffer.toArray()));
}
}

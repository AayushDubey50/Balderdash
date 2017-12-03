using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class gameStart : MonoBehaviour {

    public Text cntdwntxt;
    public GameObject dword;
    private float time;
    private int tsum;
    private float tme;
	// Use this for initialization
	void Start ()
    {
        GameObject bHome = GameObject.FindGameObjectWithTag("board");
        bHome.SetActive(false);
        GameObject sScreen = GameObject.FindGameObjectWithTag("StartScreen");
        sScreen.SetActive(false);
        time = 10;
        tsum = 0;
	}
	
	// Update is called once per frame
	void Update ()
    {
        //tme += Time.deltaTime;
        if(time > 0)
            time -= Time.deltaTime;
        else
        {
            time = 0;
            playGame();
        }
        int dtme = (int)time;
        Debug.Log(dtme.ToString());
        Debug.Log(Time.deltaTime);
        cntdwntxt.text = "Time For Game to Start: " + dtme + " s";
	}

    void playGame()
    {
        GameObject ws = GameObject.FindGameObjectWithTag("waitScreen");
        ws.SetActive(false);
        dword.SetActive(true);
    }
}

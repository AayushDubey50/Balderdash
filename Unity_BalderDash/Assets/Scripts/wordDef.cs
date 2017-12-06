using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class wordDef : MonoBehaviour {

    public Text timer;
    public Text Rnd;
    public GameObject defSelect;
    public camSript jg;
    float time;

	// Use this for initialization
	void Start () {
        time = 15;
        //int rnd = jg.getRnd();
        //Rnd.text = "Round: " + rnd + "/10";
	}
	
	// Update is called once per frame
	void Update ()
    {
        time -= Time.deltaTime;
        if(time < 0)
        {
            time = 0;
            defselect();
        }
        int rtme = (int)time;
        timer.text = "Time: " + rtme + " s";
	}

    void defselect()
    {
        int rnd = jg.getRnd();
        Rnd.text = "Round: " + rnd + "/10";
        GameObject wdf = GameObject.FindGameObjectWithTag("wordDef");
        time = 15;
        wdf.SetActive(false);
        defSelect.SetActive(true);
    }
}
